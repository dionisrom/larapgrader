<?php

declare(strict_types=1);

namespace Larapgrader\Confidence;

use Larapgrader\Contracts\ConfidenceScorerInterface;

/**
 * Concrete implementation of ConfidenceScorerInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class ConfidenceScorer implements ConfidenceScorerInterface
{
    /**
     * @param array<mixed> $context
     */
    public function score(array $context): float
    {
        return 0.0;
    }
}
