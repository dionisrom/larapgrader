<?php

declare(strict_types=1);

namespace Larapgrader\Services;

use InvalidArgumentException;
use JsonException;
use Larapgrader\Contracts\SymbolIndexInterface;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Const_;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\ParserFactory;
use PDO;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;

/**
 * SymbolIndexService implements SymbolIndexInterface.
 * Maintains a cross-file symbol index for classes, functions, methods, traits, interfaces, constants,
 * service bindings, custom facades, and middleware chains.
 */
class SymbolIndexService implements SymbolIndexInterface
{
    /** @var array<string, array<string, array<string, mixed>>> */
    protected array $symbols = [
        'class' => [],
        'function' => [],
        'method' => [],
        'trait' => [],
        'interface' => [],
        'constant' => [],
        'service' => [],
        'facade' => [],
        'middleware' => [],
    ];

    /** @var array<string, list<array<string, mixed>>> */
    protected array $references = [];

    /** @var array<string, list<array{type: string, key: string}>> */
    protected array $nameIndex = [];

    /**
     * @param array<string, mixed>|string $source
     */
    public function index(array|string $source, ?string $filePath = null): void
    {
        if (is_string($source)) {
            $paths = $this->collectPhpFiles($source);

            foreach ($paths as $path) {
                $this->indexPhpFile($path);
            }

            return;
        }

        if (null === $filePath || '' === $filePath) {
            throw new InvalidArgumentException('filePath is required when indexing an AST array source.');
        }

        $this->indexStructuredAst($source, $filePath);
    }

    /**
     * @return array<string, mixed>|null
     */
    public function lookup(string $name, ?string $type = null): ?array
    {
        if (null !== $type) {
            if (!isset($this->symbols[$type])) {
                return null;
            }

            if (isset($this->symbols[$type][$name])) {
                return $this->symbols[$type][$name];
            }

            $needle = strtolower($name);
            foreach ($this->symbols[$type] as $symbol) {
                if (isset($symbol['short_name']) && strtolower((string) $symbol['short_name']) === $needle) {
                    return $symbol;
                }
            }

            return null;
        }

        foreach ($this->symbols as $bucket) {
            if (isset($bucket[$name])) {
                return $bucket[$name];
            }
        }

        $needle = strtolower($name);
        if (!isset($this->nameIndex[$needle])) {
            return null;
        }

        $candidate = $this->nameIndex[$needle][0] ?? null;
        if (null === $candidate) {
            return null;
        }

        return $this->symbols[$candidate['type']][$candidate['key']] ?? null;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getReferences(string $name, ?string $type = null): array
    {
        $symbol = $this->lookup($name, $type);
        if (null === $symbol || !isset($symbol['key'])) {
            return [];
        }

        $key = (string) $symbol['key'];
        return $this->references[$key] ?? [];
    }

    public function persist(string $outputPath): void
    {
        if ('' === trim($outputPath)) {
            throw new InvalidArgumentException('outputPath must not be empty.');
        }

        $directory = dirname($outputPath);
        if (!is_dir($directory) && !mkdir($directory, 0777, true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Unable to create directory: %s', $directory));
        }

        if ($this->isSqlitePath($outputPath)) {
            $this->persistSqlite($outputPath);
            return;
        }

        $payload = [
            'version' => 1,
            'symbols' => $this->symbols,
            'references' => $this->references,
        ];

        try {
            $encoded = json_encode($payload, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        } catch (JsonException $exception) {
            throw new RuntimeException('Failed to encode symbol index JSON.', 0, $exception);
        }

        if (false === file_put_contents($outputPath, $encoded)) {
            throw new RuntimeException(sprintf('Failed to write symbol index file: %s', $outputPath));
        }
    }

    public function load(string $inputPath): void
    {
        if (!is_file($inputPath)) {
            throw new InvalidArgumentException(sprintf('Input path does not exist: %s', $inputPath));
        }

        $this->symbols = $this->emptySymbolBuckets();
        $this->references = [];
        $this->nameIndex = [];

        if ($this->isSqlitePath($inputPath)) {
            $this->loadSqlite($inputPath);
            return;
        }

        $content = file_get_contents($inputPath);
        if (false === $content) {
            throw new RuntimeException(sprintf('Failed to read symbol index file: %s', $inputPath));
        }

        try {
            $decoded = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $exception) {
            throw new RuntimeException('Failed to decode symbol index JSON.', 0, $exception);
        }

        if (!is_array($decoded) || !isset($decoded['symbols']) || !is_array($decoded['symbols'])) {
            throw new RuntimeException('Invalid symbol index JSON format: missing symbols.');
        }

        /** @var array<string, array<string, array<string, mixed>>> $symbols */
        $symbols = $decoded['symbols'];
        $this->symbols = array_replace($this->emptySymbolBuckets(), $symbols);

        if (isset($decoded['references']) && is_array($decoded['references'])) {
            /** @var array<string, list<array<string, mixed>>> $references */
            $references = $decoded['references'];
            $this->references = $references;
        }

        $this->rebuildNameIndex();
    }

    public function search(string $query): array
    {
        $needle = strtolower(trim($query));
        if ('' === $needle) {
            return [];
        }

        $results = [];
        $seen = [];

        foreach ($this->symbols as $bucket) {
            foreach ($bucket as $key => $symbol) {
                $haystack = strtolower((string) ($symbol['key'] ?? $key) . ' ' . (string) ($symbol['short_name'] ?? ''));
                if (!str_contains($haystack, $needle)) {
                    continue;
                }

                if (isset($seen[$key])) {
                    continue;
                }

                $seen[$key] = true;
                $results[] = $symbol;
            }
        }

        return $results;
    }

    /**
     * @return list<string>
     */
    protected function collectPhpFiles(string $source): array
    {
        if (is_file($source)) {
            if ('php' !== strtolower(pathinfo($source, PATHINFO_EXTENSION))) {
                throw new InvalidArgumentException('Only PHP files can be indexed when source is a file path.');
            }

            return [$source];
        }

        if (!is_dir($source)) {
            throw new InvalidArgumentException(sprintf('Source path does not exist: %s', $source));
        }

        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));

        foreach ($iterator as $entry) {
            if (!$entry instanceof SplFileInfo || !$entry->isFile()) {
                continue;
            }

            if ('php' !== strtolower($entry->getExtension())) {
                continue;
            }

            $files[] = $entry->getPathname();
        }

        sort($files);
        return $files;
    }

    protected function indexPhpFile(string $filePath): void
    {
        $content = file_get_contents($filePath);
        if (false === $content) {
            throw new RuntimeException(sprintf('Failed to read file: %s', $filePath));
        }

        $parser = (new ParserFactory())->createForNewestSupportedVersion();
        $nodes = $parser->parse($content) ?? [];

        $this->indexPhpNodes($nodes, $filePath, '');
    }

    /**
     * @param array<mixed> $ast
     */
    protected function indexStructuredAst(array $ast, string $filePath): void
    {
        $namespace = (string) ($ast['namespace'] ?? '');
        $classes = isset($ast['classes']) && is_array($ast['classes']) ? $ast['classes'] : [];
        foreach ($classes as $classInfo) {
            if (!is_array($classInfo) || !isset($classInfo['name'])) {
                continue;
            }

            $className = (string) $classInfo['name'];
            $classKey = $this->qualify($namespace, $className);
            $this->addSymbol('class', $classKey, [
                'type' => 'class',
                'key' => $classKey,
                'short_name' => $className,
                'namespace' => $namespace,
                'file' => $filePath,
            ]);

            if (array_key_exists('extends', $classInfo) && null !== $classInfo['extends']) {
                $this->addReference($classKey, [
                    'relationship' => 'extends',
                    'target' => $this->qualify($namespace, (string) $classInfo['extends']),
                    'file' => $filePath,
                ]);
            }

            $methods = isset($classInfo['methods']) && is_array($classInfo['methods']) ? $classInfo['methods'] : [];
            foreach ($methods as $methodName) {
                if (!is_string($methodName) || '' === $methodName) {
                    continue;
                }

                $methodKey = $classKey . '::' . $methodName;
                $this->addSymbol('method', $methodKey, [
                    'type' => 'method',
                    'key' => $methodKey,
                    'short_name' => $methodName,
                    'class' => $classKey,
                    'file' => $filePath,
                ]);
            }
        }

        $functions = isset($ast['functions']) && is_array($ast['functions']) ? $ast['functions'] : [];
        foreach ($functions as $functionName) {
            if (!is_string($functionName) || '' === $functionName) {
                continue;
            }

            $functionKey = $this->qualify($namespace, $functionName);
            $this->addSymbol('function', $functionKey, [
                'type' => 'function',
                'key' => $functionKey,
                'short_name' => $functionName,
                'namespace' => $namespace,
                'file' => $filePath,
            ]);
        }

        $interfaces = isset($ast['interfaces']) && is_array($ast['interfaces']) ? $ast['interfaces'] : [];
        foreach ($interfaces as $interfaceName) {
            if (!is_string($interfaceName) || '' === $interfaceName) {
                continue;
            }

            $interfaceKey = $this->qualify($namespace, $interfaceName);
            $this->addSymbol('interface', $interfaceKey, [
                'type' => 'interface',
                'key' => $interfaceKey,
                'short_name' => $interfaceName,
                'namespace' => $namespace,
                'file' => $filePath,
            ]);
        }
    }

    /**
     * @param array<Node> $nodes
     */
    protected function indexPhpNodes(array $nodes, string $filePath, string $namespace, ?string $ownerSymbol = null): void
    {
        foreach ($nodes as $node) {
            if ($node instanceof Namespace_) {
                $namespaceName = $node->name instanceof Name ? $node->name->toString() : '';
                $this->indexPhpNodes($node->stmts, $filePath, $namespaceName, $ownerSymbol);
                continue;
            }

            if ($node instanceof Class_) {
                $this->indexClassNode($node, $filePath, $namespace);
                continue;
            }

            if ($node instanceof Trait_) {
                $traitName = $node->name instanceof Identifier ? $node->name->toString() : '';
                if ('' !== $traitName) {
                    $traitKey = $this->qualify($namespace, $traitName);
                    $this->addSymbol('trait', $traitKey, [
                        'type' => 'trait',
                        'key' => $traitKey,
                        'short_name' => $traitName,
                        'namespace' => $namespace,
                        'file' => $filePath,
                        'line' => $node->getStartLine(),
                    ]);
                }

                $this->traverseForPatterns($node, $filePath, $namespace, $ownerSymbol);
                continue;
            }

            if ($node instanceof Interface_) {
                if (!$node->name instanceof Identifier) {
                    continue;
                }

                $interfaceName = $node->name->toString();
                $interfaceKey = $this->qualify($namespace, $interfaceName);
                $this->addSymbol('interface', $interfaceKey, [
                    'type' => 'interface',
                    'key' => $interfaceKey,
                    'short_name' => $interfaceName,
                    'namespace' => $namespace,
                    'file' => $filePath,
                    'line' => $node->getStartLine(),
                ]);

                continue;
            }

            if ($node instanceof Function_) {
                $functionName = $node->name->toString();
                $functionKey = $this->qualify($namespace, $functionName);
                $this->addSymbol('function', $functionKey, [
                    'type' => 'function',
                    'key' => $functionKey,
                    'short_name' => $functionName,
                    'namespace' => $namespace,
                    'file' => $filePath,
                    'line' => $node->getStartLine(),
                ]);

                continue;
            }

            if ($node instanceof Const_) {
                foreach ($node->consts as $constNode) {
                    $constName = $constNode->name->toString();
                    $constKey = $this->qualify($namespace, $constName);
                    $this->addSymbol('constant', $constKey, [
                        'type' => 'constant',
                        'key' => $constKey,
                        'short_name' => $constName,
                        'namespace' => $namespace,
                        'file' => $filePath,
                        'line' => $node->getStartLine(),
                    ]);
                }

                continue;
            }

            if ($node instanceof Expression) {
                $this->traverseForPatterns($node, $filePath, $namespace, $ownerSymbol);
                continue;
            }

            $this->traverseForPatterns($node, $filePath, $namespace, $ownerSymbol);
        }
    }

    protected function indexClassNode(Class_ $node, string $filePath, string $namespace): void
    {
        if (!$node->name instanceof Identifier) {
            return;
        }

        $className = $node->name->toString();
        $classKey = $this->qualify($namespace, $className);

        $this->addSymbol('class', $classKey, [
            'type' => 'class',
            'key' => $classKey,
            'short_name' => $className,
            'namespace' => $namespace,
            'file' => $filePath,
            'line' => $node->getStartLine(),
        ]);

        if ($node->extends instanceof Name) {
            $this->addReference($classKey, [
                'relationship' => 'extends',
                'target' => $this->qualifyNodeName($namespace, $node->extends),
                'file' => $filePath,
                'line' => $node->getStartLine(),
            ]);
        }

        foreach ($node->implements as $implements) {
            $this->addReference($classKey, [
                'relationship' => 'implements',
                'target' => $this->qualifyNodeName($namespace, $implements),
                'file' => $filePath,
                'line' => $node->getStartLine(),
            ]);
        }

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof ClassMethod) {
                $methodName = $stmt->name->toString();
                $methodKey = $classKey . '::' . $methodName;
                $this->addSymbol('method', $methodKey, [
                    'type' => 'method',
                    'key' => $methodKey,
                    'short_name' => $methodName,
                    'class' => $classKey,
                    'file' => $filePath,
                    'line' => $stmt->getStartLine(),
                ]);

                $this->traverseForPatterns($stmt, $filePath, $namespace, $classKey);
                continue;
            }

            if ($stmt instanceof TraitUse) {
                foreach ($stmt->traits as $traitName) {
                    $this->addReference($classKey, [
                        'relationship' => 'uses_trait',
                        'target' => $this->qualifyNodeName($namespace, $traitName),
                        'file' => $filePath,
                        'line' => $stmt->getStartLine(),
                    ]);
                }

                continue;
            }

            if ($stmt instanceof ClassConst) {
                foreach ($stmt->consts as $constNode) {
                    $constName = $constNode->name->toString();
                    $constKey = $classKey . '::' . $constName;
                    $this->addSymbol('constant', $constKey, [
                        'type' => 'constant',
                        'key' => $constKey,
                        'short_name' => $constName,
                        'class' => $classKey,
                        'file' => $filePath,
                        'line' => $stmt->getStartLine(),
                    ]);
                }

                continue;
            }

            $this->traverseForPatterns($stmt, $filePath, $namespace, $classKey);
        }
    }

    protected function traverseForPatterns(Node $node, string $filePath, string $namespace, ?string $ownerSymbol = null): void
    {
        if ($node instanceof MethodCall) {
            $methodName = $node->name instanceof Identifier ? strtolower($node->name->toString()) : '';

            if (in_array($methodName, ['bind', 'singleton', 'scoped'], true)) {
                $serviceName = $this->extractArgumentName($node->args[0] ?? null, $namespace);
                if (null !== $serviceName) {
                    $serviceKey = $this->qualify($namespace, $serviceName);
                    $this->addSymbol('service', $serviceKey, [
                        'type' => 'service',
                        'key' => $serviceKey,
                        'short_name' => $serviceName,
                        'file' => $filePath,
                        'line' => $node->getStartLine(),
                    ]);

                    if (null !== $ownerSymbol) {
                        $this->addReference($ownerSymbol, [
                            'relationship' => 'service_binding',
                            'target' => $serviceKey,
                            'file' => $filePath,
                            'line' => $node->getStartLine(),
                        ]);
                    }
                }
            }

            if ('middleware' === $methodName) {
                $middlewares = $this->extractMiddlewareNames($node->args[0] ?? null);
                foreach ($middlewares as $middlewareName) {
                    $middlewareKey = $this->qualify($namespace, $middlewareName);
                    $this->addSymbol('middleware', $middlewareKey, [
                        'type' => 'middleware',
                        'key' => $middlewareKey,
                        'short_name' => $middlewareName,
                        'file' => $filePath,
                        'line' => $node->getStartLine(),
                    ]);

                    if (null !== $ownerSymbol) {
                        $this->addReference($ownerSymbol, [
                            'relationship' => 'middleware_chain',
                            'target' => $middlewareKey,
                            'file' => $filePath,
                            'line' => $node->getStartLine(),
                        ]);
                    }
                }
            }
        }

        if ($node instanceof StaticCall && $node->class instanceof Name) {
            $facadeName = $this->qualifyNodeName($namespace, $node->class);
            if ($this->isCustomFacade($facadeName)) {
                $this->addSymbol('facade', $facadeName, [
                    'type' => 'facade',
                    'key' => $facadeName,
                    'short_name' => $this->shortName($facadeName),
                    'file' => $filePath,
                    'line' => $node->getStartLine(),
                ]);

                if (null !== $ownerSymbol) {
                    $this->addReference($ownerSymbol, [
                        'relationship' => 'facade_usage',
                        'target' => $facadeName,
                        'file' => $filePath,
                        'line' => $node->getStartLine(),
                    ]);
                }
            }
        }

        foreach ($node->getSubNodeNames() as $subNodeName) {
            $subNode = $node->{$subNodeName};

            if ($subNode instanceof Node) {
                $this->traverseForPatterns($subNode, $filePath, $namespace, $ownerSymbol);
                continue;
            }

            if (is_array($subNode)) {
                foreach ($subNode as $item) {
                    if ($item instanceof Node) {
                        $this->traverseForPatterns($item, $filePath, $namespace, $ownerSymbol);
                    }
                }
            }
        }
    }

    /**
     * @param array<string, mixed> $metadata
     */
    protected function addSymbol(string $type, string $key, array $metadata): void
    {
        if (!isset($this->symbols[$type])) {
            $this->symbols[$type] = [];
        }

        $this->symbols[$type][$key] = $metadata;

        $shortName = isset($metadata['short_name']) ? (string) $metadata['short_name'] : $this->shortName($key);
        $this->indexName($shortName, $type, $key);
        $this->indexName($key, $type, $key);
    }

    /**
     * @param array<string, mixed> $reference
     */
    protected function addReference(string $symbolKey, array $reference): void
    {
        if (!isset($this->references[$symbolKey])) {
            $this->references[$symbolKey] = [];
        }

        $this->references[$symbolKey][] = $reference;
    }

    protected function indexName(string $name, string $type, string $key): void
    {
        $normalized = strtolower($name);
        if ('' === $normalized) {
            return;
        }

        if (!isset($this->nameIndex[$normalized])) {
            $this->nameIndex[$normalized] = [];
        }

        foreach ($this->nameIndex[$normalized] as $candidate) {
            if ($candidate['type'] === $type && $candidate['key'] === $key) {
                return;
            }
        }

        $this->nameIndex[$normalized][] = ['type' => $type, 'key' => $key];
    }

    protected function rebuildNameIndex(): void
    {
        $this->nameIndex = [];

        foreach ($this->symbols as $type => $bucket) {
            foreach ($bucket as $key => $metadata) {
                $shortName = isset($metadata['short_name']) ? (string) $metadata['short_name'] : $this->shortName($key);
                $this->indexName($shortName, $type, $key);
                $this->indexName($key, $type, $key);
            }
        }
    }

    protected function qualify(string $namespace, string $name): string
    {
        $name = ltrim($name, '\\');
        if ('' === trim($namespace)) {
            return $name;
        }

        return trim($namespace, '\\') . '\\' . $name;
    }

    protected function qualifyNodeName(string $namespace, Name $name): string
    {
        if ($name->isFullyQualified()) {
            return $name->toString();
        }

        return $this->qualify($namespace, $name->toString());
    }

    protected function shortName(string $fqName): string
    {
        $parts = explode('\\', $fqName);
        return (string) end($parts);
    }

    protected function isCustomFacade(string $className): bool
    {
        if (str_starts_with($className, 'Illuminate\\')) {
            return false;
        }

        return str_contains($className, '\\Facades\\') || str_ends_with($className, 'Facade');
    }

    protected function extractArgumentName(?Node $arg, string $namespace): ?string
    {
        if (!$arg instanceof Arg) {
            return null;
        }

        if ($arg->value instanceof String_) {
            return $arg->value->value;
        }

        if ($arg->value instanceof ClassConstFetch && $arg->value->class instanceof Name) {
            return $this->qualifyNodeName($namespace, $arg->value->class);
        }

        return null;
    }

    /**
     * @return list<string>
     */
    protected function extractMiddlewareNames(?Node $arg): array
    {
        if (!$arg instanceof Arg) {
            return [];
        }

        if ($arg->value instanceof String_) {
            return [$arg->value->value];
        }

        if ($arg->value instanceof Node\Expr\Array_) {
            $values = [];
            foreach ($arg->value->items as $item) {
                if ($item->value instanceof String_) {
                    $values[] = $item->value->value;
                }
            }

            return $values;
        }

        return [];
    }

    protected function isSqlitePath(string $path): bool
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($extension, ['sqlite', 'sqlite3', 'db'], true);
    }

    protected function persistSqlite(string $outputPath): void
    {
        $pdo = new PDO('sqlite:' . $outputPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec('CREATE TABLE IF NOT EXISTS symbol_index (type TEXT NOT NULL, key_name TEXT NOT NULL, data_json TEXT NOT NULL, PRIMARY KEY(type, key_name))');
        $pdo->exec('CREATE TABLE IF NOT EXISTS symbol_references (symbol_key TEXT NOT NULL PRIMARY KEY, data_json TEXT NOT NULL)');
        $pdo->exec('DELETE FROM symbol_index');
        $pdo->exec('DELETE FROM symbol_references');

        $symbolStatement = $pdo->prepare('INSERT INTO symbol_index(type, key_name, data_json) VALUES (:type, :key_name, :data_json)');
        $referenceStatement = $pdo->prepare('INSERT INTO symbol_references(symbol_key, data_json) VALUES (:symbol_key, :data_json)');

        foreach ($this->symbols as $type => $bucket) {
            foreach ($bucket as $key => $metadata) {
                $symbolStatement->execute([
                    ':type' => $type,
                    ':key_name' => $key,
                    ':data_json' => json_encode($metadata, JSON_THROW_ON_ERROR),
                ]);
            }
        }

        foreach ($this->references as $symbolKey => $refs) {
            $referenceStatement->execute([
                ':symbol_key' => $symbolKey,
                ':data_json' => json_encode($refs, JSON_THROW_ON_ERROR),
            ]);
        }
    }

    protected function loadSqlite(string $inputPath): void
    {
        $pdo = new PDO('sqlite:' . $inputPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $symbolsQuery = $pdo->query('SELECT type, key_name, data_json FROM symbol_index');
        if (false !== $symbolsQuery) {
            while (false !== ($row = $symbolsQuery->fetch(PDO::FETCH_ASSOC))) {
                $type = (string) $row['type'];
                $key = (string) $row['key_name'];

                /** @var array<string, mixed> $decoded */
                $decoded = json_decode((string) $row['data_json'], true, 512, JSON_THROW_ON_ERROR);

                if (!isset($this->symbols[$type])) {
                    $this->symbols[$type] = [];
                }

                $this->symbols[$type][$key] = $decoded;
            }
        }

        $refsQuery = $pdo->query('SELECT symbol_key, data_json FROM symbol_references');
        if (false !== $refsQuery) {
            while (false !== ($row = $refsQuery->fetch(PDO::FETCH_ASSOC))) {
                $symbolKey = (string) $row['symbol_key'];

                /** @var list<array<string, mixed>> $decoded */
                $decoded = json_decode((string) $row['data_json'], true, 512, JSON_THROW_ON_ERROR);
                $this->references[$symbolKey] = $decoded;
            }
        }

        $this->rebuildNameIndex();
    }

    /**
     * @return array<string, array<string, array<string, mixed>>>
     */
    protected function emptySymbolBuckets(): array
    {
        return [
            'class' => [],
            'function' => [],
            'method' => [],
            'trait' => [],
            'interface' => [],
            'constant' => [],
            'service' => [],
            'facade' => [],
            'middleware' => [],
        ];
    }
}
