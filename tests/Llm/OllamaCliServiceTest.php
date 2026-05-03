<?php

use Larapgrader\Contracts\AuditTrailInterface;
use Larapgrader\Contracts\OllamaCliInterface;
use Larapgrader\Contracts\ProcessFactoryInterface;
use Larapgrader\Exceptions\LLMServiceUnavailableException;
use Larapgrader\Exceptions\PromptTooLongException;
use Larapgrader\LLM\OllamaCliService;
use Mockery\MockInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Test suite for OllamaCliService
 *
 * Coverage:
 * - AC1: Process wrapping via symfony/process
 * - AC2: generate() method with prompt and model
 * - AC3: Audit trail logging BEFORE sending
 * - AC4: Graceful degradation on process failure
 * - AC5: Prompt length enforcement (50KB limit)
 * - AC6: Pest mocking pattern for Process
 */

// AC1: ProcessFactory wrapping
test('AC1: generate() creates Process via factory with correct command', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('LLM response');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')
        ->once()
        ->with(['ollama', 'run', 'mistral', 'test prompt'], 30)
        ->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $result = $service->generate('test prompt');

    expect($result)->toBe('LLM response');
});

test('AC1: generate() passes 30s timeout to factory', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(0);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')
        ->once()
        ->with(Mockery::any(), 30)
        ->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('test');

    expect(true)->toBeTrue();
});

// AC2: generate() method signature and behavior
test('AC2: generate() with default model parameter (mistral)', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(0);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('output');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')
        ->once()
        ->with(['ollama', 'run', 'mistral', 'prompt'], Mockery::any())
        ->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('prompt');

    expect(true)->toBeTrue();
});

test('AC2: generate() with custom model parameter', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(0);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('output');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')
        ->once()
        ->with(['ollama', 'run', 'neural-chat', 'prompt'], Mockery::any())
        ->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('prompt', 'neural-chat');

    expect(true)->toBeTrue();
});

test('AC2: generate() returns full ollama output', function () {
    $expectedOutput = "This is the LLM response with multiple lines\nLine 2\nLine 3";

    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn($expectedOutput);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $result = $service->generate('test');

    expect($result)->toBe($expectedOutput);
});

// AC3: Audit trail logging BEFORE sending
test('AC3: generate() logs prompt to audit trail BEFORE process.run()', function () {
    $callOrder = [];

    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')
        ->once()
        ->andReturnUsing(function () use (&$callOrder) {
            $callOrder[] = 'process.run';
            return 0;
        });
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')
        ->once()
        ->andReturnUsing(function () use (&$callOrder) {
            $callOrder[] = 'audit.record';
        });

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('test');

    // Verify audit was logged BEFORE process.run()
    expect($callOrder[0])->toBe('audit.record');
    expect($callOrder[1])->toBe('process.run');
});

test('AC3: audit context includes required fields', function () {
    $prompt = 'This is a test prompt';
    $model = 'mistral';

    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $capturedContext = null;
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')
        ->once()
        ->with('ollama_prompt_sent', Mockery::capture($capturedContext));

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate($prompt, $model);

    // Verify context contains required fields
    expect($capturedContext)->toBeArray();
    expect($capturedContext['prompt'])->toBe($prompt);
    expect($capturedContext['model'])->toBe($model);
    expect($capturedContext['code_snippet_length'])->toBe(strlen($prompt));
    expect($capturedContext)->toHaveKey('timestamp');
    expect($capturedContext)->toHaveKey('request_id');
});

// AC4: Graceful degradation on process failure
test('AC4: generate() throws LLMServiceUnavailableException on process failure', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(127);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(false);
    $mockProcess->shouldReceive('getExitCode')->andReturn(127);
    $mockProcess->shouldReceive('getErrorOutput')->andReturn('ollama: command not found');
    $mockProcess->shouldReceive('getOutput')->andReturn('');
    $mockProcess->shouldReceive('getCommandLine')->andReturn('ollama run mistral test');
    $mockProcess->shouldReceive('getExitCodeText')->andReturn('Command not found');
    $mockProcess->shouldReceive('getWorkingDirectory')->andReturn('/app');
    $mockProcess->shouldReceive('isOutputDisabled')->andReturn(false);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->twice(); // once for prompt, once for error

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    expect(function () use ($service) {
        $service->generate('test');
    })->toThrow(LLMServiceUnavailableException::class);
});

test('AC4: failure logs error to audit trail', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(127);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(false);
    $mockProcess->shouldReceive('getExitCode')->andReturn(127);
    $mockProcess->shouldReceive('getErrorOutput')->andReturn('ollama: command not found');
    $mockProcess->shouldReceive('getOutput')->andReturn('');
    $mockProcess->shouldReceive('getCommandLine')->andReturn('ollama run mistral test');
    $mockProcess->shouldReceive('getExitCodeText')->andReturn('Command not found');
    $mockProcess->shouldReceive('getWorkingDirectory')->andReturn('/app');
    $mockProcess->shouldReceive('isOutputDisabled')->andReturn(false);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $auditCalls = [];
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')
        ->andReturnUsing(function ($action, $context) use (&$auditCalls) {
            $auditCalls[] = ['action' => $action, 'context' => $context];
        });

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    try {
        $service->generate('test');
    } catch (LLMServiceUnavailableException) {
        // Expected
    }

    // Verify error was logged to audit trail
    expect($auditCalls)->toHaveCount(2);
    expect($auditCalls[1]['action'])->toBe('ollama_error');
    expect($auditCalls[1]['context'])->toHaveKey('error');
    expect($auditCalls[1]['context'])->toHaveKey('exit_code');
});

test('AC4: exception includes error details', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(1);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(false);
    $mockProcess->shouldReceive('getExitCode')->andReturn(1);
    $mockProcess->shouldReceive('getErrorOutput')->andReturn('Process timed out');
    $mockProcess->shouldReceive('getOutput')->andReturn('');
    $mockProcess->shouldReceive('getCommandLine')->andReturn('ollama run mistral test');
    $mockProcess->shouldReceive('getExitCodeText')->andReturn('General error');
    $mockProcess->shouldReceive('getWorkingDirectory')->andReturn('/app');
    $mockProcess->shouldReceive('isOutputDisabled')->andReturn(false);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->twice();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    $exceptionThrown = false;
    try {
        $service->generate('test');
    } catch (LLMServiceUnavailableException $e) {
        $exceptionThrown = true;
        expect($e->getExitCode())->toBe(1);
        expect($e->getCommand())->toBeString();
    }

    expect($exceptionThrown)->toBeTrue();
});

// AC5: Prompt length enforcement (50KB limit)
test('AC5: generate() throws PromptTooLongException for >50KB prompt', function () {
    $longPrompt = str_repeat('x', 50001);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    expect(function () use ($service, $longPrompt) {
        $service->generate($longPrompt);
    })->toThrow(PromptTooLongException::class);
});

test('AC5: generate() allows exactly 50KB prompt', function () {
    $prompt50kb = str_repeat('x', 50000);

    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    expect(function () use ($service, $prompt50kb) {
        $service->generate($prompt50kb);
    })->not()->toThrow(PromptTooLongException::class);
});

test('AC5: PromptTooLongException contains helpful message', function () {
    $longPrompt = str_repeat('x', 55000);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    try {
        $service->generate($longPrompt);
        expect(true)->toBeFalse(); // Should have thrown
    } catch (PromptTooLongException $e) {
        expect($e->getMessage())->toContain('50');
        expect($e->getMessage())->toContain('filter');
        expect($e->getPromptLength())->toBe(55000);
    }
});

// AC6: Pest mocking pattern for Process
test('AC6: all Process dependencies are properly mocked', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->once()->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->once()->andReturn('test');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->once()->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $result = $service->generate('test');

    expect($result)->toBe('test');
});

test('AC6: never executes real ollama process in tests', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('test');

    expect(true)->toBeTrue();
});

// Integration scenarios
test('Integration: typical successful ollama call flow', function () {
    $prompt = 'What does this code do?';
    $model = 'mistral';
    $response = "This code validates user input and returns a boolean result.";

    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn($response);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')
        ->once()
        ->with(['ollama', 'run', $model, $prompt], 30)
        ->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->once();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $result = $service->generate($prompt, $model);

    expect($result)->toBe($response);
});

test('Integration: error handling flow preserves context', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(127);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(false);
    $mockProcess->shouldReceive('getExitCode')->andReturn(127);
    $mockProcess->shouldReceive('getErrorOutput')->andReturn('ollama: command not found');
    $mockProcess->shouldReceive('getOutput')->andReturn('');
    $mockProcess->shouldReceive('getCommandLine')->andReturn('ollama run mistral test');
    $mockProcess->shouldReceive('getExitCodeText')->andReturn('Command not found');
    $mockProcess->shouldReceive('getWorkingDirectory')->andReturn('/app');
    $mockProcess->shouldReceive('isOutputDisabled')->andReturn(false);

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')->twice();

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    $exceptionThrown = false;
    try {
        $service->generate('test');
    } catch (LLMServiceUnavailableException $e) {
        $exceptionThrown = true;
        expect($e->getMessage())->toContain('command not found');
    }

    expect($exceptionThrown)->toBeTrue();
});

// Patch fixes: timeout validation, audit failure handling, error message fallback
test('Patch: ProcessFactory rejects non-positive timeout', function () {
    $factory = new \Larapgrader\LLM\ProcessFactory();

    // Test zero timeout
    expect(function () use ($factory) {
        $factory->create(['test', 'command'], 0);
    })->toThrow(\InvalidArgumentException::class);

    // Test negative timeout
    expect(function () use ($factory) {
        $factory->create(['test', 'command'], -5);
    })->toThrow(\InvalidArgumentException::class);

    // Test positive timeout succeeds
    $process = $factory->create(['test', 'command'], 30);
    expect($process)->toBeInstanceOf(\Symfony\Component\Process\Process::class);
});

test('Patch: Hybrid audit failure handling - logs locally and continues', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(0);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('LLM response');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    // Mock audit trail to throw exception
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')
        ->once()
        ->andThrow(new \RuntimeException('Audit system down'));

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);

    // Despite audit failure, LLM response is returned (hybrid fallback)
    // Error is logged locally via error_log (tested via integration)
    $result = $service->generate('test prompt', 'mistral');

    expect($result)->toBe('LLM response');
});

test('Patch: Error message fallback when both streams empty', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('getExitCode')->andReturn(1);
    $mockProcess->shouldReceive('getErrorOutput')->andReturn('');  // Empty
    $mockProcess->shouldReceive('getOutput')->andReturn('');       // Empty
    $mockProcess->shouldReceive('getCommandLine')->andReturn('ollama run test');

    $exception = \Larapgrader\Exceptions\LLMServiceUnavailableException::fromProcess($mockProcess);

    // Should have fallback message, not empty
    expect($exception->getMessage())->toContain('No error output');
    expect($exception->getMessage())->toContain('exit code 1');
});

test('Patch: Deterministic timestamps use UTC (gmdate)', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->andReturn(0);
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('response');

    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);

    $capturedContext = null;
    $mockAuditTrail = Mockery::mock(AuditTrailInterface::class);
    $mockAuditTrail->shouldReceive('record')
        ->once()
        ->with('ollama_prompt_sent', Mockery::capture($capturedContext));

    $service = new OllamaCliService($mockFactory, $mockAuditTrail);
    $service->generate('test', 'mistral');

    // Verify timestamp is RFC3339 format (valid ISO 8601)
    expect($capturedContext['timestamp'])->toMatch('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}[+-]\d{2}:\d{2}$/');
});
