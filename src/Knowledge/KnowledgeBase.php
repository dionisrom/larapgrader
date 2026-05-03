<?php

declare(strict_types=1);

namespace Larapgrader\Knowledge;

use Larapgrader\Contracts\KnowledgeBaseInterface;

/**
 * Concrete implementation of KnowledgeBaseInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class KnowledgeBase implements KnowledgeBaseInterface
{
    /**
     * @param array<mixed> $resolution
     */
    public function store(string $patternHash, array $resolution): void
    {
    }

    /**
     * @return array<mixed>|null
     */
    public function retrieve(string $patternHash): ?array
    {
        return null;
    }
}
