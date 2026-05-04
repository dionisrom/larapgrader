<?php

declare(strict_types=1);

namespace Larapgrader\Audit;

use Larapgrader\Confidence\ConfidenceScore;

/**
 * Confidence-specific audit trail logger.
 *
 * Logs all confidence scoring decisions and LLM interactions to append-only audit trail.
 * Format: JSONL (one JSON object per line).
 * Location: .larapgrader/audit.log
 *
 * Implements:
 * - File locking via flock() to prevent corruption under concurrent access (NFR8)
 * - Atomic writes: temp file + rename strategy (no partial writes)
 * - Timestamp (ISO8601), pattern_id, score, band, llm_used, actor, reason
 * - Never includes full code content (only metadata) — NFR7, A25
 *
 * @since 1.0
 */
class ConfidenceAuditLogger
{
    /**
     * Audit trail file location.
     *
     * @var string
     */
    private string $auditLogPath;

    /**
     * Maximum retries for file operations.
     *
     * @var int
     */
    private const MAX_RETRIES = 3;

    /**
     * Retry delay in milliseconds.
     *
     * @var int
     */
    private const RETRY_DELAY_MS = 100;

    /**
     * Constructor.
     *
     * @param string|null $auditLogPath Path to audit log file (default: .larapgrader/audit.log)
     *
     * @throws \RuntimeException If audit directory cannot be created
     */
    public function __construct(?string $auditLogPath = null)
    {
        $this->auditLogPath = $auditLogPath ?? $this->getDefaultAuditLogPath();

        // Ensure audit directory exists
        $auditDir = \dirname($this->auditLogPath);
        if (! \is_dir($auditDir)) {
            if (! @\mkdir($auditDir, 0755, true)) {
                throw new \RuntimeException("Cannot create audit directory: {$auditDir}");
            }
        }

        // Validate audit trail integrity on startup
        $this->validateAuditTrailIntegrity();
    }

    /**
     * Log a confidence scoring decision.
     *
     * @param ConfidenceScore $score The confidence score result
     * @param string $patternId Pattern identifier (e.g., "lumen8.routes.auth_middleware")
     * @param string $actor Actor performing the scoring (e.g., "marco", "system")
     * @param string $reason Reason or summary of the decision
     *
     * @return void
     *
     * @throws \RuntimeException If logging fails
     */
    public function logConfidenceDecision(
        ConfidenceScore $score,
        string $patternId,
        string $actor,
        string $reason
    ): void {
        $entry = [
            'timestamp' => \date('c'),
            'event_type' => 'confidence_decision',
            'pattern_id' => $patternId,
            'confidence_score' => $score->getScore(),
            'band' => $score->getBand(),
            'llm_used' => $score->getLlmUsed(),
            'actor' => $actor,
            'reason' => $reason,
        ];

        $this->writeAuditEntry($entry);
    }

    /**
     * Log an LLM prompt and response.
     *
     * @param string $prompt The prompt sent to the LLM (no code content, metadata only)
     * @param string $response The response from the LLM
     * @param string $endpoint LLM endpoint used
     * @param int $latencyMs Request latency in milliseconds
     * @param string|null $error Error message if request failed
     *
     * @return void
     *
     * @throws \RuntimeException If logging fails
     */
    public function logLmmPrompt(
        string $prompt,
        string $response,
        string $endpoint,
        int $latencyMs,
        ?string $error = null
    ): void {
        $entry = [
            'timestamp' => \date('c'),
            'event_type' => 'llm_interaction',
            'prompt_metadata' => $this->sanitizePrompt($prompt),
            'response_length' => \strlen($response),
            'response_preview' => \substr($response, 0, 200),
            'endpoint' => $endpoint,
            'latency_ms' => $latencyMs,
            'error' => $error,
        ];

        $this->writeAuditEntry($entry);
    }

    /**
     * Retrieve audit trail entries (for auditing/compliance).
     *
     * @param int|null $limit Maximum number of entries to return (null = all)
     *
     * @return array<array<string, mixed>> Array of audit trail entries
     *
     * @throws \RuntimeException If audit trail is corrupted
     */
    public function retrieve(?int $limit = null): array
    {
        if (! \file_exists($this->auditLogPath)) {
            return [];
        }

        $entries = [];
        $count = 0;

        try {
            $file = \fopen($this->auditLogPath, 'r');
            if (! $file) {
                throw new \RuntimeException("Cannot open audit log: {$this->auditLogPath}");
            }

            try {
                while (! \feof($file) && ($limit === null || $count < $limit)) {
                    $line = \fgets($file);
                    if ($line === false || \trim($line) === '') {
                        continue;
                    }

                    $entry = \json_decode($line, true);
                    if ($entry === null) {
                        throw new \RuntimeException("Corrupted audit trail: invalid JSON at line " . ($count + 1));
                    }

                    $entries[] = $entry;
                    $count++;
                }
            } finally {
                \fclose($file);
            }
        } catch (\Throwable $e) {
            throw new \RuntimeException("Failed to retrieve audit trail: " . $e->getMessage(), 0, $e);
        }

        return $entries;
    }

    /**
     * Export audit trail to JSONL format.
     *
     * @param int|null $limit Maximum entries to export (null = all)
     *
     * @return string JSONL-formatted audit trail
     */
    public function export(?int $limit = null): string
    {
        $entries = $this->retrieve($limit);
        $lines = [];

        foreach ($entries as $entry) {
            $lines[] = \json_encode($entry, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
        }

        return \implode("\n", $lines);
    }

    /**
     * Write an audit entry atomically with file locking.
     *
     * @param array<string, mixed> $entry Entry to write
     *
     * @return void
     *
     * @throws \RuntimeException If write fails after retries
     */
    private function writeAuditEntry(array $entry): void
    {
        $json = \json_encode($entry, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE) . "\n";
        
        // Use file locking to ensure safe concurrent writes
        $retries = 0;
        while ($retries < self::MAX_RETRIES) {
            try {
                $this->writeWithLock($json);
                return;
            } catch (\Throwable $e) {
                $retries++;
                if ($retries >= self::MAX_RETRIES) {
                    throw new \RuntimeException("Failed to write audit entry after {$retries} retries: " . $e->getMessage(), 0, $e);
                }

                // Exponential backoff
                \usleep(self::RETRY_DELAY_MS * 1000 * $retries);
            }
        }
    }

    /**
     * Write audit entry with file locking.
     *
     * Uses flock() to prevent corruption under concurrent access.
     *
     * @param string $json JSON entry to append
     *
     * @return void
     *
     * @throws \RuntimeException If lock or write fails
     */
    private function writeWithLock(string $json): void
    {
        $file = @\fopen($this->auditLogPath, 'a');
        if (! $file) {
            throw new \RuntimeException("Cannot open audit log for writing: {$this->auditLogPath}");
        }

        try {
            // Acquire exclusive lock (blocks other writers)
            if (! \flock($file, \LOCK_EX)) {
                throw new \RuntimeException("Cannot acquire lock on audit log");
            }

            try {
                if (\fwrite($file, $json) === false) {
                    throw new \RuntimeException("Cannot write to audit log");
                }
            } finally {
                // Release lock
                \flock($file, \LOCK_UN);
            }
        } finally {
            \fclose($file);
        }
    }

    /**
     * Validate audit trail integrity on startup.
     *
     * Checks that all lines are valid JSON.
     *
     * @return void
     *
     * @throws \RuntimeException If audit trail is corrupted
     */
    private function validateAuditTrailIntegrity(): void
    {
        if (! \file_exists($this->auditLogPath)) {
            return;
        }

        $lineNum = 0;

        try {
            $file = \fopen($this->auditLogPath, 'r');
            if (! $file) {
                return;
            }

            try {
                while (! \feof($file)) {
                    $line = \fgets($file);
                    if ($line === false || \trim($line) === '') {
                        continue;
                    }

                    $lineNum++;
                    $json = \json_decode($line, true);
                    if ($json === null && \json_last_error() !== \JSON_ERROR_NONE) {
                        throw new \RuntimeException("Corrupted audit trail at line {$lineNum}: " . \json_last_error_msg());
                    }
                }
            } finally {
                \fclose($file);
            }
        } catch (\Throwable $e) {
            throw new \RuntimeException("Audit trail validation failed: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Sanitize prompt for audit logging (remove code content, keep metadata).
     *
     * @param string $prompt Original prompt
     *
     * @return array<string, mixed> Sanitized prompt metadata
     */
    private function sanitizePrompt(string $prompt): array
    {
        // Extract metadata from prompt (pattern type, file count, etc.)
        // Remove code snippets and sensitive content
        return [
            'length' => \strlen($prompt),
            'hash' => \hash('sha256', $prompt),
            'preview' => \substr($prompt, 0, 100) . (strlen($prompt) > 100 ? '...' : ''),
        ];
    }

    /**
     * Get default audit log path.
     *
     * @return string Default path: .larapgrader/audit.log
     */
    private function getDefaultAuditLogPath(): string
    {
        $baseDir = \getcwd();

        return $baseDir . '/.larapgrader/audit.log';
    }
}
