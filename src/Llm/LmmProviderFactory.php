<?php

declare(strict_types=1);

namespace Larapgrader\Llm;

use Larapgrader\Contracts\AuditTrailInterface;
use Larapgrader\Contracts\OllamaCliInterface;
use Larapgrader\Llm\Providers\ApprovedToolProvider;
use Larapgrader\Llm\Providers\OllamaProviderAdapter;

/**
 * LLM Provider Factory with fallback chain.
 *
 * Implements hierarchical provider selection (A4):
 * 1. Primary: GitHub Copilot Enterprise (approved tool)
 * 2. Fallback 1: Local Ollama instance
 * 3. Fallback 2: Score-only (no explanation) if both unavailable
 *
 * All LLM calls respect timeout (10s max) and include error handling.
 * Gracefully degrades to score-only if providers unavailable.
 *
 * @since 1.0
 */
class LmmProviderFactory
{
    /**
     * Constructor.
     *
     * @param OllamaCliInterface $ollamaCli Ollama CLI service for fallback
     * @param AuditTrailInterface $auditTrail Audit trail for logging
     * @param string|null $approvedToolApiKey GitHub Copilot API key (if configured)
     * @param string|null $ollamaModel Ollama model name (default: mistral)
     * @param string|null $ollamaEndpoint Ollama endpoint (default: http://localhost:11434)
     */
    public function __construct(
        private OllamaCliInterface $ollamaCli,
        private AuditTrailInterface $auditTrail,
        private ?string $approvedToolApiKey = null,
        private ?string $ollamaModel = null,
        private ?string $ollamaEndpoint = null
    ) {
    }

    /**
     * Get the best available LLM provider (following fallback chain).
     *
     * Tries providers in order:
     * 1. GitHub Copilot Enterprise (if API key configured)
     * 2. Ollama (always available as fallback)
     * 3. Returns null if score-only fallback should be used
     *
     * @return ApprovedToolProvider|OllamaProviderAdapter|null
     *         Best available provider, or null for score-only fallback
     */
    public function getProvider(): ApprovedToolProvider|OllamaProviderAdapter|null
    {
        // Try approved tool first (GitHub Copilot Enterprise)
        $approvedTool = $this->createApprovedToolProvider();
        if ($approvedTool && $approvedTool->isAvailable()) {
            $this->auditTrail->record('llm_provider_selected', [
                'provider' => 'github_copilot_enterprise',
                'timestamp' => \date('c'),
            ]);

            return $approvedTool;
        }

        // Fallback 1: Try Ollama
        $ollamaAdapter = $this->createOllamaAdapter();
        if ($ollamaAdapter->isAvailable()) {
            $this->auditTrail->record('llm_provider_selected', [
                'provider' => 'ollama',
                'model' => $ollamaAdapter->getModel(),
                'timestamp' => \date('c'),
            ]);

            return $ollamaAdapter;
        }

        // Fallback 2: Score-only (no LLM explanation)
        $this->auditTrail->record('llm_provider_unavailable', [
            'reason' => 'Both approved tool and Ollama unavailable',
            'fallback' => 'score_only',
            'timestamp' => \date('c'),
        ]);

        return null;
    }

    /**
     * Get an approved LLM tool provider.
     *
     * @return ApprovedToolProvider|null Provider if API key configured, null otherwise
     */
    private function createApprovedToolProvider(): ?ApprovedToolProvider
    {
        $apiKey = $this->approvedToolApiKey ?? \getenv('GITHUB_COPILOT_TOKEN');
        $this->approvedToolApiKey = $apiKey ?: null;

        if (! $apiKey) {
            return null;
        }

        return new ApprovedToolProvider(
            $this->auditTrail,
            \getenv('GITHUB_COPILOT_ENDPOINT') ?: null,
            $this->approvedToolApiKey
        );
    }

    /**
     * Get an Ollama provider adapter.
     *
     * @return OllamaProviderAdapter Always returns adapter (Ollama is always fallback)
     */
    private function createOllamaAdapter(): OllamaProviderAdapter
    {
        return new OllamaProviderAdapter(
            $this->ollamaCli,
            $this->auditTrail,
            $this->ollamaModel,
            $this->ollamaEndpoint
        );
    }

    /**
     * Query any available LLM with fallback chain.
     *
     * Attempts to query best available provider.
     * If all providers fail, returns score-only indicator.
     *
     * @param string $prompt The prompt to send
     * @param int $timeoutSeconds Request timeout (default 10s)
     *
     * @return string LLM response, or empty string if score-only fallback
     */
    public function queryWithFallback(string $prompt, int $timeoutSeconds = 10): string
    {
        $provider = $this->getProvider();

        if (! $provider) {
            // Score-only fallback
            return '';
        }

        try {
            return $provider->query($prompt);
        } catch (\Throwable $e) {
            // Log the failure
            $this->auditTrail->record('llm_query_failed', [
                'error' => $e->getMessage(),
                'timestamp' => \date('c'),
            ]);

            // Fall back to score-only
            return '';
        }
    }
}
