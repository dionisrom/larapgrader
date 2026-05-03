<?php

declare(strict_types=1);

namespace Larapgrader\Audit;

use Larapgrader\Contracts\AuditTrailInterface;

/**
 * Concrete implementation of AuditTrailInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class AuditTrail implements AuditTrailInterface
{
    /**
     * @param array<mixed> $context
     */
    public function record(string $action, array $context): void
    {
    }

    public function export(?string $format = null): string
    {
        return '';
    }
}
