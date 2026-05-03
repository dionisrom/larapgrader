<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Ollama Provider that wraps local Mistral LLM.
 * (A4: Use Ollama CLI wrapper for LLM features)
 */
interface OllamaProviderInterface
{
    /**
     * Query the LLM with a prompt.
     *
     * @param string $prompt The prompt to send
     * @return string The LLM response
     */
    public function query(string $prompt): string;

    /**
     * Get a plain-English explanation for a migration decision.
     *
     * @param array<mixed> $context Context including file, change, confidence
     * @return string Plain-English explanation
     */
    public function explain(array $context): string;
}
