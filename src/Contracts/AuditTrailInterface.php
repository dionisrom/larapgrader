<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for Audit Trail that logs migration decisions.
 */
interface AuditTrailInterface
{
    /**
     * Record a migration decision or action.
     *
     * @param string $action The action performed
     * @param array<mixed> $context Additional context data
     * @return void
     */
    public function record(string $action, array $context): void;

    /**
     * Export the full audit trail.
     *
     * @param string|null $format Export format (json, jsonl, etc.)
     * @return string Exported audit trail content
     */
    public function export(?string $format = null): string;
}
