<?php

declare(strict_types=1);

namespace Larapgrader\AST;

use Larapgrader\Contracts\SymbolIndexInterface;

/**
 * Concrete implementation of SymbolIndexInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class SymbolIndex implements SymbolIndexInterface
{
    /**
     * @param array<mixed> $ast
     * @param string $filePath
     */
    public function index(array $ast, string $filePath): void
    {
    }

    /**
     * @param string $query
     * @return array<mixed>
     */
    public function search(string $query): array
    {
        return [];
    }
}
