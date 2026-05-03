<?php

declare(strict_types=1);

use Larapgrader\AST\AstParser;

/*
|--------------------------------------------------------------------------
| AST Benchmark Tests
|--------------------------------------------------------------------------
| Validates NFR1 and memory constraints using a synthetic 100k-line file.
*/

test('benchmark parses synthetic 100k lines within 5 minutes (NFR1)', function () {
    $parser = AstParser::createDefault();

    $file = __DIR__ . '/../../Fixtures/benchmarks/synthetic_100k.php';
    expect(file_exists($file))->toBeTrue();

    $start = microtime(true);
    $result = $parser->parseFile($file);
    $duration = microtime(true) - $start;

    expect($result)->toBeArray();
    expect($duration)->toBeLessThanOrEqual(300.0);

    // Attach benchmark context to output for implementation evidence.
    fwrite(STDOUT, sprintf("\nBenchmark duration: %.4fs\n", $duration));
});

test('benchmark stays under 512MB peak memory (NFR20)', function () {
    $parser = AstParser::createDefault();

    $file = __DIR__ . '/../../Fixtures/benchmarks/synthetic_100k.php';
    $parser->parseFile($file);

    $peak = memory_get_peak_usage(true);
    expect($peak)->toBeLessThanOrEqual(512 * 1024 * 1024);

    fwrite(STDOUT, sprintf("Peak memory usage: %.2f MB\n", $peak / 1024 / 1024));
});
