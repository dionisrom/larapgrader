<?php

declare(strict_types=1);

namespace Larapgrader\AST;

use Larapgrader\Contracts\AstParserInterface;
use Larapgrader\Exceptions\ParsingException;
use PhpParser\Node\Stmt;
use PhpParser\Parser;

/**
 * Adapter for nikic/php-parser that implements AstParserInterface.
 * 
 * Parses PHP files and returns structured AST arrays
 * with keys in snake_case for consistency (A21).
 */
class AstParser implements AstParserInterface
{
    private Parser $parser;

    /**
     * Constructor with dependency injection (A20).
     * 
     * @param Parser $parser nikic/php-parser instance
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Static factory method to create instance with default parser.
     * 
     * @return self
     */
    public static function createDefault(): self
    {
        $parser = (new \PhpParser\ParserFactory())->createForNewestSupportedVersion();
        return new self($parser);
    }

    /**
     * Parse a single PHP file and return its AST representation.
     * 
     * @param string $filePath Absolute path to the PHP file
     * @return array<string, mixed>|null Structured AST array, or null if file unreadable
     * @throws ParsingException If PHP syntax is invalid
     */
    public function parseFile(string $filePath): ?array
    {
        if (!is_readable($filePath)) {
            return null;
        }

        $code = file_get_contents($filePath);
        if ($code === false) {
            return null;
        }

        // Strip UTF-8 BOM if present (Windows editors often add this)
        if (str_starts_with($code, "\xEF\xBB\xBF")) {
            $code = substr($code, 3);
        }

        try {
            /** @var list<Stmt>|null $ast */
            $ast = $this->parser->parse($code);

            if ($ast === null) {
                return null;
            }

            return $this->convertToStructuredArray($ast, $filePath);
        } catch (\PhpParser\Error $e) {
            throw new ParsingException(
                "Syntax error in {$filePath}: " . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Convert nikic/php-parser AST nodes to structured array.
     * 
    * @param list<Stmt> $ast Array of AST nodes
     * @param string $filePath Original file path for context
    * @return array<string, mixed> Structured AST with snake_case keys (A21)
     */
    private function convertToStructuredArray(array $ast, string $filePath): array
    {
        $result = [
            'file' => $filePath,
            'namespace' => null,
            'classes' => [],
            'functions' => [],
            'interfaces' => [],
        ];

        foreach ($ast as $node) {
            if ($node instanceof \PhpParser\Node\Stmt\Namespace_) {
                $result['namespace'] = $node->name ? $node->name->toString() : null;
                $this->extractClassesAndFunctions($node->stmts, $result);
            } else {
                $this->extractClassesAndFunctions([$node], $result);
            }
        }

        return $result;
    }

    /**
     * Extract classes, functions, and interfaces from AST nodes.
     * 
    * @param array<int, Stmt> $stmts Array of statements
     * @param array<string, mixed> &$result Reference to result array
     */
    private function extractClassesAndFunctions(array $stmts, array &$result): void
    {
        foreach ($stmts as $stmt) {
            if ($stmt instanceof \PhpParser\Node\Stmt\Class_) {
                if ($stmt->name === null) {
                    continue;
                }

                $extends = null;
                if ($stmt->extends !== null) {
                    $extends = $stmt->extends->toString();
                }
                
                $result['classes'][] = [
                    'name' => $stmt->name->toString(),
                    'extends' => $extends,
                    'methods' => $this->extractMethods($stmt),
                ];
            } elseif ($stmt instanceof \PhpParser\Node\Stmt\Function_) {
                $result['functions'][] = [
                    'name' => $stmt->name->toString(),
                ];
            } elseif ($stmt instanceof \PhpParser\Node\Stmt\Interface_) {
                if (!$stmt->name instanceof \PhpParser\Node\Identifier) {
                    continue;
                }

                $result['interfaces'][] = [
                    'name' => $stmt->name->toString(),
                ];
            }
        }
    }

    /**
     * Extract method names from a class node.
     * 
     * @param \PhpParser\Node\Stmt\Class_ $classNode
     * @return array<int, string> Array of method names
     */
    private function extractMethods(\PhpParser\Node\Stmt\Class_ $classNode): array
    {
        $methods = [];
        foreach ($classNode->getMethods() as $method) {
            // method->name is guaranteed to be non-null by PhpParser
            $methods[] = $method->name->toString();
        }
        return $methods;
    }
}
