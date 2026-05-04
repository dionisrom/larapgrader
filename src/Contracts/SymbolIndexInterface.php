<?php

declare(strict_types=1);


namespace Larapgrader\Contracts;

/**
 * Interface SymbolIndexInterface
 * Defines the contract for a cross-file symbol index supporting classes, functions, methods, traits, interfaces, constants,
 * service bindings, custom facades, and middleware chains.
 */
interface SymbolIndexInterface
{
    /**
     * Indexes all relevant symbols in the given codebase path or AST.
     *
        * @param array<string, mixed>|string $source Either a base path (string) or structured AST (array)
     * @param string|null $filePath Optional file path if indexing AST
     * @return void
     */
    public function index(array|string $source, ?string $filePath = null): void;

    /**
     * Looks up a symbol by name and type.
     *
     * @param string $name
     * @param string|null $type (class, function, method, trait, interface, constant, service, facade, middleware)
    * @return array<string, mixed>|null Symbol metadata or null if not found
     */
    public function lookup(string $name, ?string $type = null): ?array;

    /**
     * Returns all cross-file references for a given symbol.
     *
     * @param string $name
     * @param string|null $type
    * @return list<array<string, mixed>> List of references (file, line, type, relationship)
     */
    public function getReferences(string $name, ?string $type = null): array;

    /**
     * Persists the symbol index to the state registry (JSON or SQLite).
     *
     * @param string $outputPath
     * @return void
     */
    public function persist(string $outputPath): void;

    /**
     * Loads the symbol index from the state registry.
     *
     * @param string $inputPath
     * @return void
     */
    public function load(string $inputPath): void;

    /**
     * Search for symbols by name or pattern (legacy, for compatibility).
     *
     * @param string $query The search query
     * @return array<mixed> Array of matching symbols with locations
     */
    public function search(string $query): array;
}
