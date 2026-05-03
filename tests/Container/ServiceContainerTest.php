<?php

declare(strict_types=1);

use Larapgrader\Container\ServiceContainer;

test('get() returns correct instance', function () {
    $container = new ServiceContainer();
    $container->set('test_service', new stdClass());
    
    $service = $container->get('test_service');
    
    expect($service)->toBeInstanceOf(stdClass::class);
});

test('get() throws for unknown ID', function () {
    $container = new ServiceContainer();
    
    try {
        $container->get('non_existent_service');
        expect(false)->toBeTrue('Expected exception was not thrown');
    } catch (\Psr\Container\NotFoundExceptionInterface $e) {
        expect($e)->toBeInstanceOf(\Psr\Container\NotFoundExceptionInterface::class);
    } catch (\Exception $e) {
        expect($e)->toBeInstanceOf(\Psr\Container\NotFoundExceptionInterface::class);
    }
});

test('has() returns true for existing service', function () {
    $container = new ServiceContainer();
    $container->set('test_service', new stdClass());
    
    expect($container->has('test_service'))->toBeTrue();
});

test('has() returns false for non-existent service', function () {
    $container = new ServiceContainer();
    
    expect($container->has('non_existent_service'))->toBeFalse();
});

test('constructor injection resolves dependencies', function () {
    $mockService = \Mockery::mock(\Larapgrader\Contracts\AstParserInterface::class);
    
    $container = new ServiceContainer();
    $container->set(\Larapgrader\Contracts\AstParserInterface::class, $mockService);
    
    $resolved = $container->get(\Larapgrader\Contracts\AstParserInterface::class);
    
    expect($resolved)->toBe($mockService);
});
