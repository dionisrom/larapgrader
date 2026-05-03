<?php

declare(strict_types=1);

namespace Tests\Helpers;

final class TestDataFactory
{
    /**
     * @return array<string, mixed>
     */
    public static function migrationContractFixture(): array
    {
        return [
            'schema_version' => '1.0',
            'thresholds' => [
                'auto_migrate' => 85,
                'manual_review' => 60,
            ],
            'protected_paths' => [
                'app/Http/Kernel.php',
                'bootstrap/app.php',
            ],
        ];
    }
}
