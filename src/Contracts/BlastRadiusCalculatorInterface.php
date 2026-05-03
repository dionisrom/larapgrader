<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Blast Radius Calculator that maps cascading changes.
 */
interface BlastRadiusCalculatorInterface
{
    /**
     * Calculate blast radius for a given change.
     *
     * @param string $filePath The file being changed
     * @param array<mixed> $changeDescription Description of the change
     * @return array<string, mixed> Array of affected files with impact scores
     */
    public function calculate(string $filePath, array $changeDescription): array;
}
