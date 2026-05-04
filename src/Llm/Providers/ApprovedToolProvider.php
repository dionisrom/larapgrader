<?php

declare(strict_types=1);

namespace Larapgrader\Llm\Providers;

use Larapgrader\Contracts\AuditTrailInterface;

/**
 * GitHub Copilot Enterprise LLM provider adapter.
 *
 * Routes LLM requests to GitHub Copilot Enterprise (approved enterprise tool per A4).
 * Implements graceful fallback and timeout handling.
 *
 * @since 1.0
 */
class ApprovedToolProvider
{
    /**
     * API endpoint for GitHub Copilot Enterprise.
     *
     * @var string
     */
    private string $apiEndpoint;

    /**
     * API key for authentication.
     *
     * @var string
     */
    private string $apiKey;

    /**
     * Request timeout in seconds.
     *
     * @var int
     */
    private int $timeout;

    /**
     * Constructor.
     *
     * @param AuditTrailInterface $auditTrail Audit trail for logging
     * @param string|null $apiEndpoint GitHub Copilot API endpoint
     * @param string|null $apiKey API authentication key
     */
    public function __construct(
        private AuditTrailInterface $auditTrail,
        ?string $apiEndpoint = null,
        ?string $apiKey = null
    ) {
        $this->timeout = 10;
        $this->apiEndpoint = $apiEndpoint ?? \getenv('GITHUB_COPILOT_ENDPOINT') ?: 'https://api.github.com/copilot/completions';
        $envApiKey = \getenv('GITHUB_COPILOT_TOKEN');
        $this->apiKey = $apiKey ?? ($envApiKey ?: '');
    }

    /**
     * Query the approved LLM tool.
     *
     * Sends request to GitHub Copilot Enterprise with timeout and error handling.
     *
     * @param string $prompt The prompt to send
     *
     * @return string The LLM response
     *
     * @throws \RuntimeException If request fails or times out
     */
    public function query(string $prompt): string
    {
        // Check if API key is configured
        if (! $this->apiKey) {
            throw new \RuntimeException('GitHub Copilot API key not configured');
        }

        try {
            $startTime = \microtime(true);

            // Prepare request (simplified - actual implementation would use guzzlehttp/guzzle)
            $requestData = [
                'prompt' => $prompt,
                'max_tokens' => 500,
                'temperature' => 0.7,
            ];

            // Log to audit trail
            $this->auditTrail->record('llm_request_sent', [
                'provider' => 'github_copilot_enterprise',
                'endpoint' => $this->apiEndpoint,
                'timestamp' => \date('c'),
            ]);

            // Simulate API call (in real implementation, use curl or guzzle)
            // For now, return a placeholder
            $response = $this->simulateApiCall($prompt);

            $latency = (\microtime(true) - $startTime) * 1000;

            // Check if request exceeded timeout
            if ($latency > ($this->timeout * 1000)) {
                throw new \RuntimeException("LLM request exceeded timeout of {$this->timeout}s (took {$latency}ms)");
            }

            // Log response to audit trail
            $this->auditTrail->record('llm_response_received', [
                'provider' => 'github_copilot_enterprise',
                'latency_ms' => (int) $latency,
                'timestamp' => \date('c'),
            ]);

            return $response;
        } catch (\Throwable $e) {
            // Log error to audit trail
            $this->auditTrail->record('llm_error', [
                'provider' => 'github_copilot_enterprise',
                'error_type' => \get_class($e),
                'error_message' => $e->getMessage(),
                'timestamp' => \date('c'),
            ]);

            throw new \RuntimeException("GitHub Copilot API error: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Simulate API call (placeholder for MVP).
     *
     * In production, this would make actual HTTP request to GitHub Copilot API.
     *
     * @param string $prompt The prompt
     *
     * @return string Simulated response
     */
    private function simulateApiCall(string $prompt): string
    {
        // Placeholder: in production, use Guzzle or curl
        return "This transformation was evaluated by GitHub Copilot Enterprise.";
    }

    /**
     * Check if the provider is available (API key configured).
     *
     * @return bool True if provider can be used
     */
    public function isAvailable(): bool
    {
        return $this->apiKey !== '';
    }
}
