<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for File Manager that handles file operations.
 * (A16: FileManager in src/Files/FileManager.php)
 */
interface FileManagerInterface
{
    /**
     * Read file contents.
     *
     * @param string $filePath Path to the file
     * @return string File contents
     */
    public function read(string $filePath): string;

    /**
     * Write contents to a file.
     *
     * @param string $filePath Path to the file
     * @param string $contents Contents to write
     */
    public function write(string $filePath, string $contents): void;
}
