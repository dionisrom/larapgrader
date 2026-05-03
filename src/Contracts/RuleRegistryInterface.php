<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Rule Registry that manages migration rules.
 */
interface RuleRegistryInterface
{
    /**
     * Register a migration rule.
     *
     * @param string $ruleName Unique rule identifier
     * @param callable $ruleImplementation The rule logic
     * @return void
     */
    public function register(string $ruleName, callable $ruleImplementation): void;

    /**
     * Apply all registered rules to the given context.
     *
     * @param array<mixed> $context Migration context
     * @return array<mixed> Array of applied transformations
     */
    public function apply(array $context): array;
}
