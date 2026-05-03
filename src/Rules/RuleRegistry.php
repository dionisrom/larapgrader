<?php

declare(strict_types=1);

namespace Larapgrader\Rules;

use Larapgrader\Contracts\RuleRegistryInterface;

/**
 * Concrete implementation of RuleRegistryInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class RuleRegistry implements RuleRegistryInterface
{
    public function register(string $ruleName, callable $ruleImplementation): void
    {
    }

    /**
     * @param array<mixed> $context
     * @return array<mixed>
     */
    public function apply(array $context): array
    {
        return [];
    }
}
