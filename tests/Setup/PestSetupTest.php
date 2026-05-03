<?php

declare(strict_types=1);

use Tests\Helpers\TestDataFactory;

test('helper generates deterministic migration fixture', function () {
    // Centralized fixture builders keep setup deterministic and reusable across tests.
    $firstFixture = TestDataFactory::migrationContractFixture();
    $secondFixture = TestDataFactory::migrationContractFixture();

    expect($firstFixture)
        ->toBeArray()
        ->and($secondFixture)->toBe($firstFixture)
        ->and($firstFixture['schema_version'])->toBe('1.0')
        ->and($firstFixture['thresholds']['auto_migrate'])->toBe(85)
        ->and($firstFixture['thresholds']['manual_review'])->toBe(60)
        ->and($firstFixture['protected_paths'])->toBe([
            'app/Http/Kernel.php',
            'bootstrap/app.php',
        ]);

    $firstFixture['thresholds']['auto_migrate'] = 999;
    $freshFixture = TestDataFactory::migrationContractFixture();

    expect($freshFixture['thresholds']['auto_migrate'])->toBe(85);
});

test('mockery can mock external dependency contract', function () {
    $provider = \Mockery::mock(\Larapgrader\Contracts\OllamaProviderInterface::class);
    $provider->shouldReceive('query')->once()->with('hello')->andReturn('ok');

    expect($provider->query('hello'))->toBe('ok');
});
