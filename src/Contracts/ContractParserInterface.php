<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Migration Contract Parser.
 */
interface ContractParserInterface
{
    /**
     * Parse a Migration Contract YAML file.
     *
     * @param string $filePath Path to the YAML contract file
     * @return array<mixed> Parsed contract configuration
     */
    public function parse(string $filePath): array;

    /**
     * Validate a parsed contract against schema.
     *
     * @param array<mixed> $contract The parsed contract
     * @return bool True if valid, false otherwise
     */
    public function validate(array $contract): bool;
}
