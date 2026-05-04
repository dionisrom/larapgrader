<?php

declare(strict_types=1);

namespace Larapgrader\Confidence;

/**
 * Value object representing a confidence score for a migration transformation.
 *
 * Immutable representation of confidence score with band assignment and explanation.
 * Implements PSR-12 coding standard and uses strict types (A19, A20).
 *
 * @since 1.0
 */
class ConfidenceScore
{
    /**
     * Confidence score (0-100).
     *
     * @var int
     */
    private int $score;

    /**
     * Confidence band (auto|review|manual|high_risk).
     *
     * @var string
     */
    private string $band;

    /**
     * Plain-English explanation of the confidence score.
     *
     * @var string
     */
    private string $explanation;

    /**
     * LLM used to generate the explanation.
     *
     * @var string
     */
    private string $llmUsed;

    /**
     * Constructor for ConfidenceScore value object.
     *
     * @param int $score Confidence score between 0 and 100
     * @param string $band Confidence band: 'auto', 'review', 'manual', or 'high_risk'
     * @param string $explanation Plain-English explanation of the score
     * @param string $llmUsed LLM provider used: 'copilot_enterprise', 'ollama', or 'none'
     *
     * @throws \InvalidArgumentException If score is outside 0-100 range
     * @throws \InvalidArgumentException If band is not a valid value
     */
    public function __construct(int $score, string $band, string $explanation, string $llmUsed)
    {
        if ($score < 0 || $score > 100) {
            throw new \InvalidArgumentException("Score must be between 0 and 100, got {$score}");
        }

        $validBands = ['auto', 'review', 'manual', 'high_risk'];
        if (! in_array($band, $validBands, true)) {
            throw new \InvalidArgumentException("Band must be one of: " . implode(', ', $validBands) . ", got {$band}");
        }

        $this->score = $score;
        $this->band = $band;
        $this->explanation = $explanation;
        $this->llmUsed = $llmUsed;
    }

    /**
     * Get the confidence score (0-100).
     *
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * Get the confidence band.
     *
     * @return string One of: 'auto', 'review', 'manual', 'high_risk'
     */
    public function getBand(): string
    {
        return $this->band;
    }

    /**
     * Get the plain-English explanation.
     *
     * @return string
     */
    public function getExplanation(): string
    {
        return $this->explanation;
    }

    /**
     * Get the LLM provider used for explanation generation.
     *
     * @return string One of: 'copilot_enterprise', 'ollama', 'none'
     */
    public function getLlmUsed(): string
    {
        return $this->llmUsed;
    }

    /**
     * Convert confidence score to JSON-serializable array for audit trail storage.
     *
     * @return array<string, mixed> JSON-serializable representation
     */
    public function toAuditData(): array
    {
        return [
            'score' => $this->score,
            'band' => $this->band,
            'explanation' => $this->explanation,
            'llm_used' => $this->llmUsed,
            'timestamp' => \date('c'),
        ];
    }

    /**
     * Convert confidence score to JSON-serializable array for LLM context.
     *
     * @return array<string, mixed> Array containing score and band for LLM prompting
     */
    public function toLlmData(): array
    {
        return [
            'score' => $this->score,
            'band' => $this->band,
            'explanation' => $this->explanation,
        ];
    }
}
