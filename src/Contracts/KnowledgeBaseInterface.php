<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Knowledge Base that stores resolved patterns.
 */
interface KnowledgeBaseInterface
{
    /**
     * Store a resolved pattern in the knowledge base.
     *
     * @param string $patternHash Hash identifying the pattern
     * @param array<mixed> $resolution The resolution data
     * @return void
     */
    public function store(string $patternHash, array $resolution): void;

    /**
     * Retrieve a pattern from the knowledge base.
     *
     * @param string $patternHash Hash identifying the pattern
     * @return array<mixed>|null The resolution data or null if not found
     */
    public function retrieve(string $patternHash): ?array;
}
