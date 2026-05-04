<?php

declare(strict_types=1);

namespace Larapgrader\Confidence;

/**
 * Value object representing the five confidence scoring factors.
 *
 * Immutable container for all confidence factor scores used in the weighted additive model.
 * Each factor is normalized to 0-100 scale before weighted combination.
 * Implements PSR-12 coding standard and uses strict types (A19, A20).
 *
 * @since 1.0
 */
class ConfidenceFactors
{
    /**
     * AST Complexity factor score (35% weight).
     * Higher score = more complex AST = lower confidence.
     *
     * @var int
     */
    private int $astComplexity;

    /**
     * Cross-file Dependencies factor score (25% weight).
     * Based on blast radius file count.
     *
     * @var int
     */
    private int $crossFileDependencies;

    /**
     * Custom Code Proximity factor score (20% weight).
     * AST hop distance to custom classes/methods. Lower distance = higher risk = lower score.
     *
     * @var int
     */
    private int $customCodeProximity;

    /**
     * Rule Maturity factor score (15% weight).
     * Based on successful prior applications from knowledge base.
     *
     * @var int
     */
    private int $ruleMaturity;

    /**
     * Test Coverage factor score (5% weight).
     * Binary: 100 if tests exist, 0 if not.
     *
     * @var int
     */
    private int $testCoverage;

    /**
     * Constructor for ConfidenceFactors value object.
     *
     * @param int $astComplexity AST complexity score (0-100)
     * @param int $crossFileDependencies Cross-file dependencies score (0-100)
     * @param int $customCodeProximity Custom code proximity score (0-100)
     * @param int $ruleMaturity Rule maturity score (0-100)
     * @param int $testCoverage Test coverage score (0-100)
     *
     * @throws \InvalidArgumentException If any factor is outside 0-100 range
     */
    public function __construct(
        int $astComplexity,
        int $crossFileDependencies,
        int $customCodeProximity,
        int $ruleMaturity,
        int $testCoverage
    ) {
        $this->validateFactor('astComplexity', $astComplexity);
        $this->validateFactor('crossFileDependencies', $crossFileDependencies);
        $this->validateFactor('customCodeProximity', $customCodeProximity);
        $this->validateFactor('ruleMaturity', $ruleMaturity);
        $this->validateFactor('testCoverage', $testCoverage);

        $this->astComplexity = $astComplexity;
        $this->crossFileDependencies = $crossFileDependencies;
        $this->customCodeProximity = $customCodeProximity;
        $this->ruleMaturity = $ruleMaturity;
        $this->testCoverage = $testCoverage;
    }

    /**
     * Validate that a factor is within valid range (0-100).
     *
     * @param string $name Factor name for error messaging
     * @param int $value Factor value to validate
     *
     * @throws \InvalidArgumentException If value outside 0-100 range
     */
    private function validateFactor(string $name, int $value): void
    {
        if ($value < 0 || $value > 100) {
            throw new \InvalidArgumentException("Factor {$name} must be between 0 and 100, got {$value}");
        }
    }

    /**
     * Get AST Complexity factor (35% weight).
     *
     * @return int Score 0-100
     */
    public function getAstComplexity(): int
    {
        return $this->astComplexity;
    }

    /**
     * Get Cross-file Dependencies factor (25% weight).
     *
     * @return int Score 0-100
     */
    public function getCrossFileDependencies(): int
    {
        return $this->crossFileDependencies;
    }

    /**
     * Get Custom Code Proximity factor (20% weight).
     *
     * @return int Score 0-100
     */
    public function getCustomCodeProximity(): int
    {
        return $this->customCodeProximity;
    }

    /**
     * Get Rule Maturity factor (15% weight).
     *
     * @return int Score 0-100
     */
    public function getRuleMaturity(): int
    {
        return $this->ruleMaturity;
    }

    /**
     * Get Test Coverage factor (5% weight).
     *
     * @return int Score 0-100
     */
    public function getTestCoverage(): int
    {
        return $this->testCoverage;
    }

    /**
     * Calculate weighted confidence score using all factors.
     *
     * Formula:
     * Final Score = (AST_Complexity × 0.35) + (CrossFileDeps × 0.25) + (CustomProximity × 0.20)
     *               + (RuleMaturity × 0.15) + (TestCoverage × 0.05)
     *               × Calibration_Multiplier
     *
     * @param float $calibrationMultiplier Adjustment factor (default 1.0)
     *
     * @return float Weighted score 0-100
     *
     * @throws \InvalidArgumentException If calibration multiplier is not positive
     */
    public function calculateWeightedScore(float $calibrationMultiplier = 1.0): float
    {
        if ($calibrationMultiplier <= 0) {
            throw new \InvalidArgumentException('Calibration multiplier must be positive, got ' . $calibrationMultiplier);
        }

        $weighted = (
            ($this->astComplexity * 0.35) +
            ($this->crossFileDependencies * 0.25) +
            ($this->customCodeProximity * 0.20) +
            ($this->ruleMaturity * 0.15) +
            ($this->testCoverage * 0.05)
        ) * $calibrationMultiplier;

        // Clamp to 0-100 range
        return \max(0, \min(100, $weighted));
    }

    /**
     * Convert factors to JSON-serializable array for audit trail storage.
     *
     * @return array<string, int> JSON-serializable representation
     */
    public function toAuditData(): array
    {
        return [
            'ast_complexity' => $this->astComplexity,
            'cross_file_dependencies' => $this->crossFileDependencies,
            'custom_code_proximity' => $this->customCodeProximity,
            'rule_maturity' => $this->ruleMaturity,
            'test_coverage' => $this->testCoverage,
        ];
    }

    /**
     * Convert factors to array for metadata in LLM prompts.
     *
     * @return array<string, int> Array representation suitable for LLM input
     */
    public function toLlmMetadata(): array
    {
        return [
            'ast_complexity_score' => $this->astComplexity,
            'cross_file_dependencies_score' => $this->crossFileDependencies,
            'custom_code_proximity_score' => $this->customCodeProximity,
            'rule_maturity_score' => $this->ruleMaturity,
            'test_coverage_score' => $this->testCoverage,
        ];
    }
}
