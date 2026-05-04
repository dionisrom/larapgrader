<?php

declare(strict_types=1);

use Larapgrader\Services\SymbolIndexService;

/*
|--------------------------------------------------------------------------
| Symbol Index Benchmark Tests
|--------------------------------------------------------------------------
| Validates SymbolIndex performance target against synthetic 100k-line input.
*/

test('benchmark indexes synthetic 100k lines within 5 minutes (NFR1)', function () {
    $index = new SymbolIndexService();

    $file = __DIR__ . '/../../Fixtures/benchmarks/synthetic_100k.php';
    expect(file_exists($file))->toBeTrue();

    $start = microtime(true);
    $index->index($file);
    $duration = microtime(true) - $start;

    expect($duration)->toBeLessThanOrEqual(300.0);

    fwrite(STDOUT, sprintf("\nSymbol index duration: %.4fs\n", $duration));
});
