<?php

declare(strict_types=1);

namespace Larapgrader\Analysis;

use Larapgrader\Contracts\BlastRadiusCalculatorInterface;

/**
 * Concrete implementation of BlastRadiusCalculatorInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class BlastRadiusCalculator implements BlastRadiusCalculatorInterface
{
    /**
     * @param array<mixed> $changeDescription
     * @param string $filePath
     * @return array<string, mixed>
     */
    public function calculate(string $filePath, array $changeDescription): array
    {
        return [];
    }
}
