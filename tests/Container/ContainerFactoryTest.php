<?php

declare(strict_types=1);

use Larapgrader\Container\ContainerFactory;
use Larapgrader\Container\ServiceContainer;

test('factory creates configured container', function () {
    $container = ContainerFactory::create();
    
    expect($container)->toBeInstanceOf(ServiceContainer::class);
});

test('factory supports overrides with Mockery mocks', function () {
    $mockAstParser = \Mockery::mock(\Larapgrader\Contracts\AstParserInterface::class);
    $mockAstParser->shouldReceive('parseFile')->andReturn([]);
    
    $container = ContainerFactory::create([
        \Larapgrader\Contracts\AstParserInterface::class => $mockAstParser
    ]);
    
    $resolved = $container->get(\Larapgrader\Contracts\AstParserInterface::class);
    
    expect($resolved)->toBe($mockAstParser);
});

test('factory creates container with all interfaces wired', function () {
    $container = ContainerFactory::create();
    
    // Verify all 12 interfaces can be resolved
    $interfaces = [
        \Larapgrader\Contracts\AstParserInterface::class,
        \Larapgrader\Contracts\SymbolIndexInterface::class,
        \Larapgrader\Contracts\ConfidenceScorerInterface::class,
        \Larapgrader\Contracts\BlastRadiusCalculatorInterface::class,
        \Larapgrader\Contracts\ContractParserInterface::class,
        \Larapgrader\Contracts\RuleRegistryInterface::class,
        \Larapgrader\Contracts\StateRegistryInterface::class,
        \Larapgrader\Contracts\AuditTrailInterface::class,
        \Larapgrader\Contracts\KnowledgeBaseInterface::class,
        \Larapgrader\Contracts\CliCommandInterface::class,
        \Larapgrader\Contracts\FileManagerInterface::class,
        \Larapgrader\Contracts\OllamaProviderInterface::class,
    ];
    
    foreach ($interfaces as $interface) {
        expect($container->has($interface))->toBeTrue();

        $thrown = null;
        try {
            $resolved = $container->get($interface);
            expect($resolved)->not->toBeNull();
        } catch (\Throwable $exception) {
            $thrown = $exception;
        }

        expect($thrown)->toBeNull();
    }
});
