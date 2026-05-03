<?php

declare(strict_types=1);

use Larapgrader\AST\AstParser;
use Larapgrader\AST\ParallelProcessor;
use Larapgrader\Contracts\AstParserInterface;
use PhpParser\ParserFactory;
use Symfony\Component\Console\Output\NullOutput;

/*
|--------------------------------------------------------------------------
| Parallel Processor Tests
|--------------------------------------------------------------------------
| Tests for the ParallelProcessor class with amphp/parallel.
| Validates parallel processing, error handling, and progress reporting.
*/

test('ParallelProcessor can be instantiated', function () {
    $processor = new ParallelProcessor(10, 10);
    
    expect($processor)->toBeInstanceOf(ParallelProcessor::class);
});

test('ParallelProcessor validates maxWorkers parameter', function () {
    // Test with invalid maxWorkers (zero)
    expect(fn() => new ParallelProcessor(0, 10))
        ->toThrow(InvalidArgumentException::class);
    
    // Test with invalid maxWorkers (negative)
    expect(fn() => new ParallelProcessor(-1, 10))
        ->toThrow(InvalidArgumentException::class);
});

test('ParallelProcessor validates batchSize parameter', function () {
    // Test with invalid batchSize (zero)
    expect(fn() => new ParallelProcessor(10, 0))
        ->toThrow(InvalidArgumentException::class);
    
    // Test with invalid batchSize (negative)
    expect(fn() => new ParallelProcessor(10, -5))
        ->toThrow(InvalidArgumentException::class);
});

test('parseInParallel processes multiple files', function () {
    $processor = new ParallelProcessor(2, 5);
    
    $files = [
        __DIR__ . '/../../Fixtures/lumen8-basic/routes.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php',
    ];
    
    $results = $processor->parseInParallel($files);
    
    expect($results)->toBeArray();
    expect($results)->toHaveCount(2);
    
    // Get the actual keys (after normalization) and verify results
    $keys = array_keys($results);
    expect($results[$keys[0]])->toBeArray();
    expect($results[$keys[1]])->toBeArray();
});

test('parseInParallel handles empty array', function () {
    $processor = new ParallelProcessor();
    
    $results = $processor->parseInParallel([]);
    
    expect($results)->toBeArray();
    expect($results)->toBeEmpty();
});

test('parseInParallel continues on individual file failure', function () {
    $processor = new ParallelProcessor(2, 5);
    
    $files = [
        __DIR__ . '/../../Fixtures/lumen8-basic/routes.php',
        '/nonexistent/file.php', // This will return null (silently skipped)
        __DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php',
    ];
    
    // Should not throw exception - nonexistent file is silently skipped
    $results = $processor->parseInParallel($files);
    
    expect($results)->toBeArray();
    expect(count($results))->toBe(2); // Only the readable files
});

test('parseInParallel throws on all files failing', function () {
    $processor = new ParallelProcessor(2, 5);
    
    // Create two files with invalid PHP syntax
    $tmpFile1 = tempnam(sys_get_temp_dir(), 'test_') . '.php';
    $tmpFile2 = tempnam(sys_get_temp_dir(), 'test_') . '.php';
    file_put_contents($tmpFile1, '<?php invalid syntax 1');
    file_put_contents($tmpFile2, '<?php invalid syntax 2');
    
    $files = [$tmpFile1, $tmpFile2];
    
    try {
        $processor->parseInParallel($files);
        // Should throw exception since all files have invalid syntax
        fail('Expected ParsingException was not thrown');
    } catch (\Larapgrader\Exceptions\ParsingException $e) {
        expect($e)->toBeInstanceOf(\Larapgrader\Exceptions\ParsingException::class);
    } finally {
        unlink($tmpFile1);
        unlink($tmpFile2);
    }
});

test('progress reporting works with output interface', function () {
    $output = new NullOutput(); // Use NullOutput to avoid console output during tests
    $processor = new ParallelProcessor(2, 5, $output);
    
    $files = [
        __DIR__ . '/../../Fixtures/lumen8-basic/routes.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php',
    ];
    
    $results = $processor->parseInParallel($files);
    
    expect($results)->toBeArray();
    expect($results)->toHaveCount(2);
});

test('getWorkerMemoryLimit returns correct value (AC2)', function () {
    $processor = new ParallelProcessor();
    
    $limit = $processor->getWorkerMemoryLimit();
    
    expect($limit)->toBe(256 * 1024 * 1024); // 256MB in bytes
});

test('parseInParallel respects worker count', function () {
    // Test with different worker counts
    $processor1 = new ParallelProcessor(1, 10); // 1 worker
    $processor2 = new ParallelProcessor(4, 10); // 4 workers
    
    $files = [
        __DIR__ . '/../../Fixtures/lumen8-basic/routes.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/app.php',
    ];
    
    $results1 = $processor1->parseInParallel($files);
    $results2 = $processor2->parseInParallel($files);
    
    expect($results1)->toHaveCount(3);
    expect($results2)->toHaveCount(3);
});

test('parseInParallel handles batching correctly', function () {
    // Small batch size to test batching
    $processor = new ParallelProcessor(2, 2); // batch size = 2
    
    $files = [
        __DIR__ . '/../../Fixtures/lumen8-basic/routes.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php',
        __DIR__ . '/../../Fixtures/lumen8-basic/app.php',
    ];
    
    $results = $processor->parseInParallel($files);
    
    expect($results)->toHaveCount(3);
});
