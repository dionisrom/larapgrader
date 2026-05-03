<?php

declare(strict_types=1);

namespace Larapgrader\Contract;

use Larapgrader\Contracts\ContractParserInterface;

/**
 * Concrete implementation of ContractParserInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class ContractParser implements ContractParserInterface
{
    /**
     * @return array<mixed>
     */
    public function parse(string $filePath): array
    {
        return [];
    }

    /**
     * @param array<mixed> $contract
     */
    public function validate(array $contract): bool
    {
        return true;
    }
}
