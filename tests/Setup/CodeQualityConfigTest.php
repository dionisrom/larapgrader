<?php

declare(strict_types=1);

namespace Tests\Setup;

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringContainsString;

use RuntimeException;

// Helper function to get project root
function project_root(): string
{
    return dirname(__DIR__, 2);
}

// Test that phpstan.neon exists and contains required configuration
test('phpstan.neon exists', function () {
    $phpstanConfig = project_root() . '/phpstan.neon';
    assertFileExists($phpstanConfig, 'phpstan.neon must exist in project root');
});

// Test that phpstan.neon is configured with level 8
test('phpstan level 8 configured', function () {
    $phpstanConfig = project_root() . '/phpstan.neon';
    $content = file_get_contents($phpstanConfig);
    if (false === $content) {
        throw new RuntimeException('Unable to read phpstan.neon: ' . $phpstanConfig);
    }

    assertStringContainsString('level: 8', $content, 'phpstan.neon must have level 8 configured');
    assertStringContainsString('paths:', $content, 'phpstan.neon must have paths configured');
    assertStringContainsString('- src', $content, 'phpstan.neon must scan src directory');
});

// Test that php-cs-fixer config exists for PSR-12
test('php-cs-fixer config exists', function () {
    $fixerConfig = project_root() . '/.php-cs-fixer.php';
    assertFileExists($fixerConfig, '.php-cs-fixer.php must exist for PSR-12 code style enforcement');
});

// Test that php-cs-fixer is configured for PSR-12
test('php-cs-fixer PSR-12 configured', function () {
    $fixerConfig = project_root() . '/.php-cs-fixer.php';
    $content = file_get_contents($fixerConfig);
    if (false === $content) {
        throw new RuntimeException('Unable to read .php-cs-fixer.php: ' . $fixerConfig);
    }

    // Parse the config to validate actual configuration, not just string presence
    $config = require $fixerConfig;
    $rules = $config->getRules();

    expect(isset($rules['@PSR12']))->toBeTrue('php-cs-fixer must have @PSR12 rule registered');
    expect($rules['@PSR12'])->toBe(true, 'php-cs-fixer must have @PSR12 rule enabled');
});
