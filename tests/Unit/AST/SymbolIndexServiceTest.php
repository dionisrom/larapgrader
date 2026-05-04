<?php

declare(strict_types=1);

use Larapgrader\Contracts\SymbolIndexInterface;
use Larapgrader\Services\SymbolIndexService;

test('SymbolIndexService implements SymbolIndexInterface', function () {
    $service = new SymbolIndexService();

    expect($service)->toBeInstanceOf(SymbolIndexInterface::class);
});

test('indexes all primary symbol types from PHP files and supports namespace-aware lookup', function () {
    $dir = sys_get_temp_dir() . '/symbol-index-' . uniqid('', true);
    mkdir($dir, 0777, true);

    $aFile = $dir . '/A.php';
    $bFile = $dir . '/B.php';

    file_put_contents($aFile, <<<'PHP'
<?php
namespace App\Demo;

trait SharedTrait {}

interface Worker {}

const GLOBAL_FLAG = 1;

class CustomFacade {
    public static function run(): void {}
}

class BaseWorker {}
PHP
);

    file_put_contents($bFile, <<<'PHP'
<?php
namespace App\Demo;

class Job extends BaseWorker implements Worker
{
    use SharedTrait;

    public const VERSION = '1';

    public function register(): void
    {
        app()->singleton('demo.service', fn () => new \stdClass());
        $router->middleware(['auth', 'throttle']);
        CustomFacade::run();
    }
}

function helperFunction(): void {}
PHP
);

    $service = new SymbolIndexService();
    $service->index($dir);

    $class = $service->lookup('App\\Demo\\Job', 'class');
    $method = $service->lookup('App\\Demo\\Job::register', 'method');
    $trait = $service->lookup('App\\Demo\\SharedTrait', 'trait');
    $interface = $service->lookup('App\\Demo\\Worker', 'interface');
    $function = $service->lookup('App\\Demo\\helperFunction', 'function');
    $constant = $service->lookup('App\\Demo\\Job::VERSION', 'constant');
    $serviceBinding = $service->lookup('App\\Demo\\demo.service', 'service');
    $facade = $service->lookup('App\\Demo\\CustomFacade', 'facade');
    $middleware = $service->lookup('App\\Demo\\auth', 'middleware');

    expect($class)->toBeArray();
    expect($method)->toBeArray();
    expect($trait)->toBeArray();
    expect($interface)->toBeArray();
    expect($function)->toBeArray();
    expect($constant)->toBeArray();
    expect($serviceBinding)->toBeArray();
    expect($facade)->toBeArray();
    expect($middleware)->toBeArray();

    expect($service->lookup('Job'))->toBeArray();
    expect($service->lookup('register', 'method'))->toBeArray();

    $refs = $service->getReferences('App\\Demo\\Job', 'class');
    $relationships = array_column($refs, 'relationship');

    expect($relationships)->toContain('extends');
    expect($relationships)->toContain('implements');
    expect($relationships)->toContain('uses_trait');
});

test('supports JSON persistence and load roundtrip', function () {
    $service = new SymbolIndexService();
    $service->index([
        'namespace' => 'App\\Persist',
        'classes' => [
            [
                'name' => 'PersistedClass',
                'methods' => ['run'],
                'extends' => null,
            ],
        ],
        'functions' => ['persist_helper'],
        'interfaces' => ['PersistContract'],
    ], '/tmp/persist.php');

    $target = sys_get_temp_dir() . '/symbol-index-' . uniqid('', true) . '.json';
    $service->persist($target);

    $loaded = new SymbolIndexService();
    $loaded->load($target);

    expect($loaded->lookup('App\\Persist\\PersistedClass', 'class'))->toBeArray();
    expect($loaded->lookup('App\\Persist\\PersistedClass::run', 'method'))->toBeArray();
    expect($loaded->lookup('App\\Persist\\persist_helper', 'function'))->toBeArray();
});

test('supports SQLite persistence and load roundtrip when extension is available', function () {
    if (!extension_loaded('pdo_sqlite')) {
        test()->markTestSkipped('pdo_sqlite is not available in this environment.');
    }

    $service = new SymbolIndexService();
    $service->index([
        'namespace' => 'App\\Sqlite',
        'classes' => [
            [
                'name' => 'SqlRecord',
                'methods' => ['save'],
                'extends' => null,
            ],
        ],
        'functions' => [],
        'interfaces' => [],
    ], '/tmp/sqlite.php');

    $target = sys_get_temp_dir() . '/symbol-index-' . uniqid('', true) . '.sqlite';
    $service->persist($target);

    $loaded = new SymbolIndexService();
    $loaded->load($target);

    expect($loaded->lookup('App\\Sqlite\\SqlRecord', 'class'))->toBeArray();
    expect($loaded->lookup('App\\Sqlite\\SqlRecord::save', 'method'))->toBeArray();
});

test('search returns matching symbols by short or fully-qualified name', function () {
    $service = new SymbolIndexService();
    $service->index([
        'namespace' => 'App\\Search',
        'classes' => [
            [
                'name' => 'OrderProcessor',
                'methods' => ['processOrder'],
                'extends' => null,
            ],
        ],
        'functions' => ['process_helper'],
        'interfaces' => [],
    ], '/tmp/search.php');

    $results = $service->search('process');

    expect($results)->toBeArray();
    expect(count($results))->toBeGreaterThanOrEqual(2);
});
