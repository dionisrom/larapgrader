<?php

declare(strict_types=1);

use Larapgrader\AST\AstParser;
use Larapgrader\Contracts\AstParserInterface;
use Larapgrader\Exceptions\ParsingException;
use PhpParser\ParserFactory;

/*
|--------------------------------------------------------------------------
| AST Parser Tests
|--------------------------------------------------------------------------
| Tests for the AstParser class (NikicParserAdapter).
| Validates parsing of Lumen 8 sample files (AC5).
*/

test('AstParser implements AstParserInterface', function () {
    $parser = AstParser::createDefault();
    
    expect($parser)->toBeInstanceOf(AstParserInterface::class);
});

test('parseFile returns structured array for valid PHP file', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/routes.php');
    
    expect($result)->toBeArray();
    expect($result)->toHaveKey('file');
    expect($result)->toHaveKey('namespace');
    expect($result)->toHaveKey('classes');
    expect($result)->toHaveKey('functions');
    expect($result)->toHaveKey('interfaces');
});

test('parseFile returns null for unreadable file', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile('/nonexistent/file.php');
    
    expect($result)->toBeNull();
});

test('parseFile throws ParsingException for invalid PHP syntax', function () {
    $parser = AstParser::createDefault();
    
    // Create a temporary file with invalid PHP syntax
    $tmpFile = tempnam(sys_get_temp_dir(), 'test_') . '.php';
    file_put_contents($tmpFile, '<?php this is invalid syntax');
    
    try {
        $parser->parseFile($tmpFile);
    } catch (ParsingException $e) {
        unlink($tmpFile);
        expect($e)->toBeInstanceOf(ParsingException::class);
        return;
    }
    
    unlink($tmpFile);
    fail('Expected ParsingException was not thrown');
});

test('parseFile extracts namespace correctly', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php');
    
    expect($result['namespace'])->toBe('App\\Http\\Middleware');
});

test('parseFile extracts classes correctly', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php');
    
    expect($result['classes'])->toBeArray();
    expect($result['classes'])->toHaveCount(1);
    expect($result['classes'][0]['name'])->toBe('CorsMiddleware');
    expect($result['classes'][0]['extends'])->toBeNull(); // CorsMiddleware doesn't extend any class
});

test('parseFile extracts methods correctly', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php');
    
    $methods = $result['classes'][0]['methods'];
    expect($methods)->toContain('handle');
    expect($methods)->toContain('handlePreflight');
    expect($methods)->toContain('addCorsHeaders');
});

// Note: parseDirectory and parseFiles have been removed from AstParserInterface.
// Multi-file processing is now handled exclusively by ParallelProcessor for parallel execution.
// Tests for parseDirectory and parseFiles are covered by ParallelProcessorTest.

test('AST output has snake_case keys (A21)', function () {
    $parser = AstParser::createDefault();
    
    $result = $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/routes.php');
    
    // Verify keys are in snake_case
    expect($result)->toHaveKey('file');
    expect($result)->toHaveKey('namespace');
    expect($result)->toHaveKey('classes');
    expect($result)->toHaveKey('functions');
    expect($result)->toHaveKey('interfaces');
    
    // Verify no camelCase keys exist at top level
    $camelCaseKeys = array_filter(array_keys($result), fn($key) => preg_match('/[A-Z]/', $key));
    expect($camelCaseKeys)->toBeEmpty();
});

test('Parsing completes in <100ms per file (AC5)', function () {
    $parser = AstParser::createDefault();
    
    $start = microtime(true);
    $parser->parseFile(__DIR__ . '/../../Fixtures/lumen8-basic/CorsMiddleware.php');
    $duration = (microtime(true) - $start) * 1000; // Convert to ms
    
    expect($duration)->toBeLessThan(100); // AC5: <100ms per file
});
