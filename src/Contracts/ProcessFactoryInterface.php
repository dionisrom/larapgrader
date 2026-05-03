<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

use Symfony\Component\Process\Process;

/**
 * Interface for creating Process instances with timeout configuration.
 *
 * Enables testability and centralized timeout management for symfony/process.
 * Used by OllamaCliService to execute CLI commands.
 *
 * @see Larapgrader\LLM\ProcessFactory Default implementation
 */
interface ProcessFactoryInterface
{
    /**
     * Create a Process instance with timeout configuration.
     *
     * @param array<string> $command Command and arguments (not a shell string)
     * @param int $timeout Timeout in seconds (default: 30 for Mistral LLM)
     *
     * @return Process Configured process instance ready to run
     */
    public function create(array $command, int $timeout = 30): Process;
}
