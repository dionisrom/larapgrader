<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Symbol Index that maintains cross-file symbol references.
 */
interface SymbolIndexInterface
{
    /**
     * Index symbols in the given AST representation.
     *
     * @param array<mixed> $ast The AST representation
     * @param string $filePath The file being indexed
     * @return void
     */
    public function index(array $ast, string $filePath): void;

    /**
     * Search for symbols by name or pattern.
     *
     * @param string $query The search query
     * @return array<mixed> Array of matching symbols with locations
     */
    public function search(string $query): array;
}
