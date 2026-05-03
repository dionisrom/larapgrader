<?php

declare(strict_types=1);

namespace Larapgrader\LLM;

use Larapgrader\Contracts\ProcessFactoryInterface;
use Symfony\Component\Process\Process;

/**
 * Factory for creating Process instances with timeout configuration.
 *
 * Centralizes symfony/process creation and timeout management.
 * Enables testability by allowing Mockery to mock this factory.
 *
 * @see Larapgrader\Contracts\ProcessFactoryInterface
 */
class ProcessFactory implements ProcessFactoryInterface
{
    /**
     * Create a Process instance with timeout configuration.
     *
     * @param array<string> $command Command and arguments (not a shell string)
     * @param int $timeout Timeout in seconds (default: 30 for Mistral LLM)
     *
     * @return Process Configured process instance ready to run
     *
     * @throws \InvalidArgumentException If timeout is not positive
     */
    public function create(array $command, int $timeout = 30): Process
    {
        // Validate timeout is positive
        if ($timeout <= 0) {
            throw new \InvalidArgumentException(
                sprintf('Timeout must be positive (got %d seconds)', $timeout)
            );
        }

        $process = new Process($command);
        $process->setTimeout($timeout);

        return $process;
    }
}
