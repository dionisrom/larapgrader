<?php

declare(strict_types=1);

namespace Larapgrader\AST;

use Amp\Parallel\Worker\ContextWorkerFactory;
use Amp\Parallel\Worker\ContextWorkerPool;
use Larapgrader\Contracts\AstParserInterface;
use Larapgrader\AST\Tasks\ParseFileTask;
use Larapgrader\Exceptions\ParsingException;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Parallel processor for AST parsing using amphp/parallel.
 * 
 * Processes multiple PHP files concurrently with configurable
 * worker count (default: 10 workers per NFR1/NFR2).
 * Supports progress reporting for long operations (>60s per NFR3).
 */
class ParallelProcessor
{
    private int $maxWorkers;
    private int $batchSize;
    private ?OutputInterface $output;
    private ?ProgressBar $progressBar;

    /**
     * Constructor with dependency injection for configuration parameters.
     * 
     * Note: AstParser instances are created individually in worker processes
     * since amphp/parallel workers require isolated instances that cannot be
     * passed across process boundaries.
     *
     * @param int $maxWorkers Maximum number of parallel workers (default: 10, must be > 0)
     * @param int $batchSize Number of files per batch (default: 10, must be > 0)
     * @param OutputInterface|null $output For progress reporting (NFR3)
     * @throws \InvalidArgumentException if maxWorkers or batchSize <= 0
     */
    public function __construct(
        int $maxWorkers = 10,
        int $batchSize = 10,
        ?OutputInterface $output = null
    ) {
        if ($maxWorkers <= 0) {
            throw new \InvalidArgumentException('maxWorkers must be > 0');
        }
        if ($batchSize <= 0) {
            throw new \InvalidArgumentException('batchSize must be > 0');
        }

        $this->maxWorkers = $maxWorkers;
        $this->batchSize = $batchSize;
        $this->output = $output;
        $this->progressBar = null;
    }

    /**
     * Parse multiple files in parallel.
     *
     * @param array<int, string> $filePaths Array of file paths to parse
     * @return array<string, array<string, mixed>> Array of parse results keyed by file path
     * @throws ParsingException If critical parsing failure occurs
     */
    public function parseInParallel(array $filePaths): array
    {
        if (empty($filePaths)) {
            return [];
        }

        // Deduplicate file paths to avoid redundant parsing
        $filePaths = array_unique($filePaths);

        // Normalize paths to consistent format (prevents duplicate keys)
        $filePaths = array_map(static fn($p) => realpath($p) ?: $p, $filePaths);

        // Initialize progress bar if output is available (NFR3)
        if ($this->output !== null) {
            $this->progressBar = new ProgressBar($this->output, count($filePaths));
            $this->progressBar->setFormat('Analyzing files [%bar%] %percent:3s%% (%current%/%max%)');
        }

        // Create worker pool with configured max workers
        $pool = new ContextWorkerPool(
            $this->maxWorkers,
            new ContextWorkerFactory()
        );

        $results = [];
        $errors = [];

        try {
            $batches = array_chunk($filePaths, max(1, $this->batchSize));

            foreach ($batches as $batch) {
                $batchResults = $this->processBatch($pool, $batch);
                
                foreach ($batchResults as $filePath => $result) {
                    if ($result instanceof \Throwable) {
                        $errors[] = $result;
                        // Continue processing other files (don't halt batch)
                        continue;
                    }
                    $results[$filePath] = $result;
                    
                    // Advance progress bar only for successful parses
                    if ($this->progressBar !== null) {
                        $this->progressBar->advance();
                    }
                }
            }
        } finally {
            // Always shutdown pool, even if exception occurs (prevent resource leak)
            try {
                $pool->shutdown();
            } catch (\Throwable $e) {
                // Log shutdown error but don't mask parsing errors
                error_log('Worker pool shutdown failed: ' . $e->getMessage());
            }

            // Finish progress bar in finally block
            if ($this->progressBar !== null && $this->output !== null) {
                $this->progressBar->finish();
                $this->output->writeln(''); // New line after progress bar
            }
        }

        // If all files failed, throw exception
        if (!empty($errors) && count($results) === 0) {
            $firstError = reset($errors);
            throw new ParsingException(
                'All files failed to parse. First error: ' . $firstError->getMessage()
            );
        }

        return $results;
    }

    /**
     * Process a batch of files using the worker pool.
     *
     * @param ContextWorkerPool $pool
     * @param array<int, string> $batch
     * @return array<string, array<string, mixed>|\Throwable> Array of results (file path => result or Throwable)
     */
    private function processBatch(ContextWorkerPool $pool, array $batch): array
    {
        $results = [];
        
        foreach ($batch as $filePath) {
            try {
                $result = $pool->submit(new ParseFileTask($filePath))->await();

                // Skip null results (unreadable files) - don't track as error
                if ($result === null) {
                    continue;
                }

                $results[$filePath] = $result;
            } catch (\Throwable $e) {
                $results[$filePath] = $e;
            }
        }

        return $results;
    }

    /**
     * Get memory usage per worker (for monitoring, NFR20).
     * 
     * @return int Memory limit in bytes (256MB default per AC2)
     */
    public function getWorkerMemoryLimit(): int
    {
        return 256 * 1024 * 1024; // 256MB
    }

    /**
     * Set output for progress reporting.
     * 
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }
}
