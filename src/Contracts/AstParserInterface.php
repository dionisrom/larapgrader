<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for AST Parser that analyzes PHP code using nikic/php-parser.
 * 
 * Provides methods to parse PHP files into structured AST representations
 * with support for parallel processing via amphp/parallel.
 */
interface AstParserInterface
{
    /**
     * Parse a single PHP file and return its AST representation.
     *
     * @param string $filePath Absolute path to the PHP file
     * @return array<string, mixed>|null Structured AST array, or null if file unreadable
     * @throws \Larapgrader\Exceptions\ParsingException If PHP syntax is invalid
     */
    public function parseFile(string $filePath): ?array;
}
