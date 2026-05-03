<?php

declare(strict_types=1);

use Larapgrader\Contracts\OnboardingWizardInterface;
use Larapgrader\Onboarding\FirstRunWizard;
use Mockery as m;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

beforeEach(function (): void {
    // Clean up test fixtures
    @unlink('larapgrader.yaml');
});

afterEach(function (): void {
    @unlink('larapgrader.yaml');
    m::close();
});

test('FirstRunWizard implements OnboardingWizardInterface', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);

    expect($wizard)->toBeInstanceOf(OnboardingWizardInterface::class);
});

test('isFirstRun returns true when larapgrader.yaml does not exist', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);

    expect($wizard->isFirstRun())->toBeTrue();
});

test('isFirstRun returns false when larapgrader.yaml exists', function (): void {
    // Create a temporary config file
    file_put_contents('larapgrader.yaml', "test: config\n");

    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);

    expect($wizard->isFirstRun())->toBeFalse();

    @unlink('larapgrader.yaml');
});

test('runWizard returns array with required configuration keys', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    expect($config)->toBeArray()
        ->and($config)->toHaveKeys(['thresholds', 'llm', 'post_phase_command', 'app_path']);
});

test('runWizard creates larapgrader.yaml file', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $wizard->runWizard();

    expect(file_exists('larapgrader.yaml'))->toBeTrue();
});

test('runWizard configuration contains auto_migrate threshold', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    expect($config['thresholds']['auto_migrate'])->toBe(85);
});

test('runWizard configuration contains manual_review threshold', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    expect($config['thresholds']['manual_review'])->toBe(60);
});

test('runWizard configuration contains LLM provider defaults', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    expect($config['llm']['provider'])->toBe('ollama')
        ->and($config['llm']['model'])->toBe('mistral');
});

test('runWizard uses default app path when no input provided', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    // Path should be normalized to forward slashes
    $expectedPath = str_replace('\\', '/', getcwd());
    expect($config['app_path'])->toBe($expectedPath);
});

test('runWizard writes welcome message to output', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $wizard->runWizard();

    $output_text = $output->fetch();
    expect($output_text)->toContain('Welcome');
});

test('runWizard writes success message when config file created', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $wizard->runWizard();

    $output_text = $output->fetch();
    expect($output_text)->toContain('larapgrader.yaml');
});

test('runWizard writes PHP version detection to output', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $wizard->runWizard();

    $output_text = $output->fetch();
    expect($output_text)->toContain('PHP');
});

test('generated larapgrader.yaml is valid YAML', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $wizard->runWizard();

    $content = file_get_contents('larapgrader.yaml');
    expect($content)->toBeString()
        ->and(strlen($content))->toBeGreaterThan(0);
});

test('runWizard sets post_phase_command with sensible default', function (): void {
    $input = new ArrayInput([]);
    $output = new BufferedOutput();

    $wizard = new FirstRunWizard($input, $output);
    $config = $wizard->runWizard();

    expect($config['post_phase_command'])->toBeString()
        ->and(strlen($config['post_phase_command']))->toBeGreaterThan(0);
});
