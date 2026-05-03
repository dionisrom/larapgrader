<?php

declare(strict_types=1);

namespace Larapgrader\Files;

use Larapgrader\Contracts\FileManagerInterface;

/**
 * Concrete implementation of FileManagerInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class FileManager implements FileManagerInterface
{
    public function read(string $filePath): string
    {
        return '';
    }

    public function write(string $filePath, string $contents): void
    {
    }
}
