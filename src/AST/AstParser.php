<?php

declare(strict_types=1);

namespace Larapgrader\AST;

use Larapgrader\Contracts\AstParserInterface;

/**
 * Concrete implementation of AstParserInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class AstParser implements AstParserInterface
{
    /**
     * @param string $filePath
     * @return array<mixed>
     */
    public function parseFile(string $filePath): array
    {
        return [];
    }

    /**
     * @param string $directoryPath
     * @return array<string, array<mixed>>
     */
    public function parseDirectory(string $directoryPath): array
    {
        return [];
    }
}
