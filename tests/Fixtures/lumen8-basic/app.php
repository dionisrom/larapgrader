<?php

/*
|--------------------------------------------------------------------------
| Lumen 8 DI Container Configuration
|--------------------------------------------------------------------------
| This file demonstrates typical Lumen 8 service bindings.
| Approximately 150 lines for testing AST parsing.
| Includes singleton bindings, contextual bindings, middleware, and config.
*/

// Core Services
$app->singleton('auth', function ($app) {
    return new \App\Services\AuthService(
        $app->make('request')
    );
});

$app->singleton('log', function ($app) {
    $log = new \Monolog\Logger('lumen');
    $log->pushHandler(new \Monolog\Handler\StreamHandler(
        storage_path('logs/lumen.log'),
        \Monolog\Logger::DEBUG
    ));
    return $log;
});

// Repository bindings
$app->bind('App\Contracts\UserRepositoryInterface', 'App\Repositories\UserRepository');
$app->bind('App\Contracts\PostRepositoryInterface', 'App\Repositories\PostRepository');
$app->bind('App\Contracts\CommentRepositoryInterface', 'App\Repositories\CommentRepository');
$app->bind('App\Contracts\CategoryRepositoryInterface', 'App\Repositories\CategoryRepository');

// Business Logic Services
$app->singleton('App\Services\EmailService', function ($app) {
    return new \App\Services\EmailService(
        $app->make('log'),
        config('services.mail.host'),
        config('services.mail.port')
    );
});

$app->singleton('App\Services\CacheService', function ($app) {
    return new \App\Services\CacheService(
        new \Predis\Client([
            'scheme' => 'tcp',
            'host'   => config('database.redis.host', '127.0.0.1'),
            'port'   => config('database.redis.port', 6379),
        ])
    );
});

$app->singleton('App\Services\NotificationService', function ($app) {
    return new \App\Services\NotificationService(
        $app->make('App\Services\EmailService'),
        $app->make('log')
    );
});

$app->singleton('App\Services\PaymentService', function ($app) {
    return new \App\Services\PaymentService(
        config('services.stripe.secret_key'),
        $app->make('log')
    );
});

$app->singleton('App\Services\SearchService', function ($app) {
    return new \App\Services\SearchService(
        new \Elasticsearch\Client(),
        $app->make('log')
    );
});

// Storage Services
$app->singleton('storage', function ($app) {
    return new \League\Flysystem\Filesystem(
        new \League\Flysystem\Adapter\Local(storage_path('app'))
    );
});

// Contextual bindings for controllers
$app->when('App\Http\Controllers\UserController')
    ->needs('App\Contracts\UserRepositoryInterface')
    ->give('App\Repositories\UserRepository');

$app->when('App\Http\Controllers\PostController')
    ->needs('App\Contracts\PostRepositoryInterface')
    ->give('App\Repositories\PostRepository');

$app->when('App\Http\Controllers\CommentController')
    ->needs('App\Contracts\CommentRepositoryInterface')
    ->give('App\Repositories\CommentRepository');

// Global middleware
$app->middleware([
    'auth' => \App\Http\Middleware\Authenticate::class,
    'cors' => \App\Http\Middleware\CorsMiddleware::class,
    'throttle' => \App\Http\Middleware\ThrottleRequests::class,
    'json' => \App\Http\Middleware\JsonResponse::class,
]);

// Route middleware
$app->routeMiddleware([
    'admin' => \App\Http\Middleware\Authorize::class,
    'verified' => \App\Http\Middleware\VerifyEmail::class,
]);

// Service providers registration
$app->register(\App\Providers\AuthServiceProvider::class);
$app->register(\App\Providers\EventServiceProvider::class);
$app->register(\App\Providers\RouteServiceProvider::class);
$app->register(\App\Providers\QueryServiceProvider::class);

// Configuration loading
$app->configure('app');
$app->configure('auth');
$app->configure('broadcasting');
$app->configure('cache');
$app->configure('database');
$app->configure('filesystems');
$app->configure('mail');
$app->configure('queue');
$app->configure('services');
$app->configure('session');
$app->configure('view');
$app->configure('cors');
$app->configure('payment');

// Exception handler binding
$app->singleton(\App\Exceptions\Handler::class);

// Request validation
$app->singleton('validator', function ($app) {
    return \Illuminate\Validation\Factory::make(
        $app->make('translator')
    );
});

// Event dispatcher
$app->singleton('events', function ($app) {
    return new \Illuminate\Events\Dispatcher();
});

// Queue configuration
if (config('queue.driver') === 'async') {
    $app->singleton('queue.worker', function ($app) {
        return new \App\Queue\AsyncWorker($app->make('log'));
    });
}

// Additional custom services
$app->singleton('App\Services\TranslationService', function ($app) {
    return new \App\Services\TranslationService(
        $app->make('translator'),
        $app->make('log')
    );
});

$app->singleton('App\Services\ReportingService', function ($app) {
    return new \App\Services\ReportingService(
        $app->make('database'),
        $app->make('log')
    );
});

// Cache manager for distributed caching
$app->singleton('cache.store', function ($app) {
    return new \App\Cache\DistributedCache(
        $app->make('App\Services\CacheService')
    );
});

// API versioning support
$app->singleton('api.versioner', function ($app) {
    return new \App\Api\VersionManager();
});

// Custom response factory
$app->singleton('response.factory', function ($app) {
    return new \App\Response\ResponseFactory();
});

return $app;
