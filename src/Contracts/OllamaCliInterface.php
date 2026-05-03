<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for low-level Ollama CLI execution.
 *
 * Wraps symfony/process for executing ollama CLI commands.
 * Handles prompt logging to audit trail and graceful error handling.
 *
 * @see Larapgrader\LLM\OllamaCliService Default implementation
 */
interface OllamaCliInterface
{
    /**
     * Execute ollama CLI with a prompt and model.
     *
     * Logs the prompt to audit trail BEFORE sending (NFR9, A25).
     * Enforces max prompt length of 50KB (NFR6).
     *
     * @param string $prompt The prompt to send to the LLM
     * @param string $model The model to use (default: 'mistral')
     *
     * @throws \Larapgrader\Exceptions\PromptTooLongException If prompt exceeds 50KB
     * @throws \Larapgrader\Exceptions\LLMServiceUnavailableException If ollama process fails
     * @return string The full response from ollama CLI
     */
    public function generate(string $prompt, string $model = 'mistral'): string;
}
