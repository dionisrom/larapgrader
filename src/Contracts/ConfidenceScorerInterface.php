<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

use Larapgrader\Confidence\AstAnalysis;
use Larapgrader\Confidence\ConfidenceScore;
use Larapgrader\Confidence\Rule;

/**
 * Interface for Confidence Scorer that calculates migration confidence scores.
 *
 * Implements weighted additive confidence model per requirements (FR5).
 * Integrates with LLM for plain-English explanations (A4).
 * Logs all decisions to audit trail (A25, NFR8).
 *
 * @since 1.0
 */
interface ConfidenceScorerInterface
{
    /**
     * Score a migration transformation rule based on AST analysis and context.
     *
     * Calculates confidence score using weighted model:
     * - AST Complexity (35% weight)
     * - Cross-file Dependencies (25% weight)
     * - Custom Code Proximity (20% weight)
     * - Rule Maturity (15% weight)
     * - Test Coverage (5% weight)
     *
     * SymbolIndex is injected via constructor for graceful degradation when unavailable.
     *
     * @param Rule $rule The migration transformation rule to score
     * @param AstAnalysis $analysis AST analysis results from Story 2-1
     *
     * @return ConfidenceScore Structured confidence score with band and explanation
     *
     * @throws \RuntimeException If scoring calculation fails
     */
    public function scoreRule(Rule $rule, AstAnalysis $analysis): ConfidenceScore;
}
