<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Confidence Scorer that calculates migration confidence scores.
 */
interface ConfidenceScorerInterface
{
    /**
     * Calculate confidence score for a migration transformation.
     *
     * @param array<mixed> $context Context including AST complexity, dependencies, etc.
     * @return float Confidence score between 0 and 1
     */
    public function score(array $context): float;
}
