<?php

declare(strict_types=1);

namespace Larapgrader\Llm\Providers;

use Larapgrader\Contracts\AuditTrailInterface;
use Larapgrader\Contracts\OllamaCliInterface;
use Larapgrader\Exceptions\LLMServiceUnavailableException;

/**
 * Ollama CLI LLM provider adapter.
 *
 * Routes LLM requests to local Ollama instance (fallback after approved tool per A4).
 * Wraps OllamaCliService with timeout and error handling.
 *
 * @since 1.0
 */
class OllamaProviderAdapter
{
    /**
     * Ollama model name (default: mistral).
     *
     * @var string
     */
    private string $model;

    /**
     * Ollama endpoint (default: http://localhost:11434).
     *
     * @var string
     */
    private string $endpoint;

    /**
     * Request timeout in seconds.
     *
     * @var int
     */
    private int $timeout;

    /**
     * Constructor.
     *
     * @param OllamaCliInterface $ollamaCli Low-level Ollama CLI service
     * @param AuditTrailInterface $auditTrail Audit trail for logging
     * @param string|null $model Ollama model name (default: mistral)
     * @param string|null $endpoint Ollama endpoint (default: http://localhost:11434)
     */
    public function __construct(
        private OllamaCliInterface $ollamaCli,
        private AuditTrailInterface $auditTrail,
        ?string $model = null,
        ?string $endpoint = null
    ) {
        $this->timeout = 10;
        $this->model = $model ?? \getenv('OLLAMA_MODEL') ?: 'mistral';
        $this->endpoint = $endpoint ?? \getenv('OLLAMA_ENDPOINT') ?: 'http://localhost:11434';
    }

    /**
     * Query the local Ollama instance.
     *
     * Sends request to Ollama with timeout and error handling.
     *
     * @param string $prompt The prompt to send
     *
     * @return string The LLM response
     *
     * @throws \RuntimeException If request fails or times out
     */
    public function query(string $prompt): string
    {
        try {
            $startTime = \microtime(true);

            // Log to audit trail
            $this->auditTrail->record('llm_request_sent', [
                'provider' => 'ollama',
                'model' => $this->model,
                'endpoint' => $this->endpoint,
                'timestamp' => \date('c'),
            ]);

            // Call Ollama CLI service
            $response = $this->ollamaCli->generate($prompt, $this->model);

            $latency = (\microtime(true) - $startTime) * 1000;

            // Check if request exceeded timeout
            if ($latency > ($this->timeout * 1000)) {
                throw new \RuntimeException("Ollama request exceeded timeout of {$this->timeout}s (took {$latency}ms)");
            }

            // Log response to audit trail
            $this->auditTrail->record('llm_response_received', [
                'provider' => 'ollama',
                'model' => $this->model,
                'latency_ms' => (int) $latency,
                'timestamp' => \date('c'),
            ]);

            return $response;
        } catch (LLMServiceUnavailableException $e) {
            // Log error to audit trail
            $this->auditTrail->record('llm_error', [
                'provider' => 'ollama',
                'error_type' => 'LLMServiceUnavailable',
                'error_message' => $e->getMessage(),
                'timestamp' => \date('c'),
            ]);

            throw new \RuntimeException("Ollama provider failed: " . $e->getMessage(), 0, $e);
        } catch (\Throwable $e) {
            // Log error to audit trail
            $this->auditTrail->record('llm_error', [
                'provider' => 'ollama',
                'error_type' => \get_class($e),
                'error_message' => $e->getMessage(),
                'timestamp' => \date('c'),
            ]);

            throw new \RuntimeException("Ollama provider error: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Check if the provider is available (Ollama endpoint reachable).
     *
     * Simplified check - in production would ping the Ollama endpoint.
     *
     * @return bool True if provider can be used
     */
    public function isAvailable(): bool
    {
        // Simplified availability check
        // In production, would attempt connection to Ollama endpoint
        return true;
    }

    /**
     * Set the model to use.
     *
     * @param string $model Ollama model name
     *
     * @return self For method chaining
     */
    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the configured model.
     *
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }
}
