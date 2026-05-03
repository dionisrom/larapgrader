<?php

declare(strict_types=1);

namespace Larapgrader\Exceptions;

use RuntimeException;
use Symfony\Component\Process\Process;

/**
 * Exception thrown when Ollama LLM service is unavailable or fails.
 *
 * Indicates that the ollama process failed or ollama daemon is unreachable.
 * Used for graceful degradation (NFR17) - caller can decide fallback strategy.
 */
class LLMServiceUnavailableException extends RuntimeException
{
    private int $exitCode = 0;
    private string $command = '';
    private string $errorOutput = '';

    public function __construct(
        string $message = 'LLM service unavailable',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create exception from a failed Process instance.
     *
     * @param Process $process The process that failed
     *
     * @return self
     */
    public static function fromProcess(Process $process): self
    {
        // Construct error message with fallback if both streams empty
        $errorMessage = trim($process->getErrorOutput() ?: $process->getOutput());
        if (empty($errorMessage)) {
            // Fallback message when both error and output streams are empty
            $errorMessage = 'No error output (process failed silently)';
        }

        $exception = new self(
            sprintf(
                'Ollama process failed (exit code %d): %s',
                $process->getExitCode() ?? 1,
                $errorMessage
            )
        );
        $exception->exitCode = $process->getExitCode() ?? 1;
        $exception->command = $process->getCommandLine();
        $exception->errorOutput = $process->getErrorOutput();

        return $exception;
    }

    public function getExitCode(): int
    {
        return $this->exitCode;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getErrorOutput(): string
    {
        return $this->errorOutput;
    }
}
