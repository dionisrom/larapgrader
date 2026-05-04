<?php

declare(strict_types=1);

namespace Larapgrader\Confidence;

/**
 * Value object representing a migration transformation rule.
 *
 * Contains metadata about a rule including its identity, name, and historical success data.
 * Implements PSR-12 coding standard and uses strict types (A19, A20).
 *
 * @since 1.0
 */
class Rule
{
    /**
     * Unique rule identifier (e.g., "lumen8.routes.auth_middleware").
     *
     * @var string
     */
    private string $id;

    /**
     * Human-readable rule name.
     *
     * @var string
     */
    private string $name;

    /**
     * Number of successful prior applications (for maturity calculation).
     * Capped at 10 for scoring purposes (per AC 1).
     *
     * @var int
     */
    private int $successCount;

    /**
     * Total number of applications (successful + failed).
     *
     * @var int
     */
    private int $totalApplications;

    /**
     * Pattern type (e.g., 'middleware', 'route', 'provider').
     *
     * @var string
     */
    private string $patternType;

    /**
     * Additional rule metadata.
     *
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * Constructor for Rule value object.
     *
     * @param string $id Unique rule identifier
     * @param string $name Human-readable rule name
     * @param int $successCount Number of successful applications
     * @param int $totalApplications Total applications
     * @param string $patternType Pattern type classification
     * @param array<string, mixed> $metadata Additional rule context
     *
     * @throws \InvalidArgumentException If counts are negative or inconsistent
     */
    public function __construct(
        string $id,
        string $name,
        int $successCount,
        int $totalApplications,
        string $patternType,
        array $metadata = []
    ) {
        if ($successCount < 0) {
            throw new \InvalidArgumentException("successCount must be non-negative, got {$successCount}");
        }

        if ($totalApplications < 0) {
            throw new \InvalidArgumentException("totalApplications must be non-negative, got {$totalApplications}");
        }

        if ($successCount > $totalApplications) {
            throw new \InvalidArgumentException(
                "successCount ({$successCount}) cannot exceed totalApplications ({$totalApplications})"
            );
        }

        $this->id = $id;
        $this->name = $name;
        $this->successCount = $successCount;
        $this->totalApplications = $totalApplications;
        $this->patternType = $patternType;
        $this->metadata = $metadata;
    }

    /**
     * Get the rule ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the rule name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the number of successful applications.
     *
     * @return int
     */
    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    /**
     * Get the total number of applications.
     *
     * @return int
     */
    public function getTotalApplications(): int
    {
        return $this->totalApplications;
    }

    /**
     * Get the pattern type.
     *
     * @return string
     */
    public function getPatternType(): string
    {
        return $this->patternType;
    }

    /**
     * Get success rate (0-100).
     *
     * @return float Percentage of successful applications
     */
    public function getSuccessRate(): float
    {
        if ($this->totalApplications === 0) {
            return 0.0;
        }

        return ($this->successCount / $this->totalApplications) * 100.0;
    }

    /**
     * Get metadata value by key.
     *
     * @param string $key Metadata key
     * @param mixed $default Default value if key not found
     *
     * @return mixed
     */
    public function getMetadata(string $key, mixed $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * Get all metadata.
     *
     * @return array<string, mixed>
     */
    public function getAllMetadata(): array
    {
        return $this->metadata;
    }
}
