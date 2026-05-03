<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for AST Parser that analyzes PHP code using nikic/php-parser.
 */
interface AstParserInterface
{
    /**
     * Parse a single PHP file and return AST representation.
     *
     * @param string $filePath Path to the PHP file
     * @return array<mixed> The AST representation
     */
    public function parseFile(string $filePath): array;

    /**
     * Parse all PHP files in a directory recursively.
     *
     * @param string $directoryPath Path to the directory
     * @return array<string, array<mixed>> Array of file => AST mappings
     */
    public function parseDirectory(string $directoryPath): array;
}
