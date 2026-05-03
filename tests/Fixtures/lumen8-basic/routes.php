<?php

/*
|--------------------------------------------------------------------------
| Lumen 8 Basic Routes File
|--------------------------------------------------------------------------
| This is a sample routes file for testing AST parsing.
| Contains ~200 lines of realistic Lumen 8 routing configuration.
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// User endpoints
$router->get('/users', 'UserController@index');
$router->get('/users/{id}', 'UserController@show');
$router->post('/users', 'UserController@store');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');
$router->post('/users/{id}/restore', 'UserController@restore');
$router->post('/users/{id}/deactivate', 'UserController@deactivate');

$router->group(['prefix' => 'api', 'middleware' => 'api.v1'], function () use ($router) {
    $router->get('/v1/status', function () {
        return response()->json(['status' => 'ok']);
    });
    
    $router->get('/v1/health', function () {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'version' => config('app.version'),
        ]);
    });

    $router->get('/v1/config', function () {
        return response()->json([
            'version' => '1.0.0',
            'environment' => app()->environment(),
        ]);
    });

    $router->post('/v1/debug', 'DebugController@log');
});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/profile', 'ProfileController@show');
    $router->put('/profile', 'ProfileController@update');
    $router->post('/profile/avatar', 'ProfileController@uploadAvatar');
    $router->delete('/profile/avatar', 'ProfileController@deleteAvatar');
    $router->get('/profile/preferences', 'ProfileController@preferences');
});

// Posts endpoints
$router->get('/posts', 'PostController@index');
$router->get('/posts/{id}', 'PostController@show');
$router->post('/posts', 'PostController@store');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');
$router->post('/posts/{id}/publish', 'PostController@publish');
$router->post('/posts/{id}/archive', 'PostController@archive');
$router->post('/posts/{id}/restore', 'PostController@restore');
$router->get('/posts/{id}/versions', 'PostController@versions');

// Comments endpoints
$router->get('/comments', 'CommentController@index');
$router->post('/comments', 'CommentController@store');
$router->delete('/comments/{id}', 'CommentController@destroy');
$router->put('/comments/{id}', 'CommentController@update');
$router->post('/comments/{id}/like', 'CommentController@like');
$router->delete('/comments/{id}/like', 'CommentController@unlike');

// Relationships
$router->get('/users/{id}/posts', 'UserController@posts');
$router->get('/users/{id}/comments', 'UserController@comments');
$router->get('/posts/{id}/comments', 'PostController@comments');
$router->get('/users/{user_id}/posts/{post_id}', 'UserController@showPost');

// Nested resources
$router->get('/users/{user_id}/posts/{post_id}/comments', 'CommentController@showNested');
$router->post('/users/{user_id}/posts/{post_id}/comments', 'CommentController@storeNested');
$router->delete('/users/{user_id}/posts/{post_id}/comments/{comment_id}', 'CommentController@destroyNested');

// Admin panel
$router->group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () use ($router) {
    $router->get('/dashboard', 'AdminController@dashboard');
    $router->get('/users', 'AdminController@listUsers');
    $router->post('/users/{id}/ban', 'AdminController@banUser');
    $router->post('/users/{id}/unban', 'AdminController@unbanUser');
    $router->delete('/users/{id}/force', 'AdminController@forceDelete');
    $router->get('/reports', 'AdminController@reports');
    $router->get('/analytics', 'AdminController@analytics');
});

// Named routes
$router->get('/custom-path', [
    'as' => 'custom.route',
    'uses' => 'CustomController@show'
]);

$router->post('/contact', [
    'as' => 'contact.store',
    'uses' => 'ContactController@store'
]);

// Search functionality
$router->get('/search/users', 'SearchController@users');
$router->get('/search/posts', 'SearchController@posts');
$router->get('/search/comments', 'SearchController@comments');
$router->get('/search/global', 'SearchController@global');

// Taxonomy
$router->get('/categories', 'CategoryController@index');
$router->get('/categories/{id}', 'CategoryController@show');
$router->get('/categories/{id}/posts', 'CategoryController@posts');

$router->get('/tags', 'TagController@index');
$router->get('/tags/{slug}', 'TagController@show');
$router->get('/tags/{slug}/posts', 'TagController@posts');

// Authentication
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/logout', 'AuthController@logout');
$router->post('/auth/register', 'AuthController@register');
$router->post('/auth/refresh', 'AuthController@refresh');
$router->post('/auth/forgot-password', 'AuthController@forgotPassword');
$router->post('/auth/reset-password', 'AuthController@resetPassword');
$router->post('/auth/verify-email', 'AuthController@verifyEmail');

// User settings
$router->group(['middleware' => 'auth', 'prefix' => 'settings'], function () use ($router) {
    $router->get('/', 'SettingsController@show');
    $router->put('/', 'SettingsController@update');
    $router->get('/privacy', 'SettingsController@privacy');
    $router->put('/privacy', 'SettingsController@updatePrivacy');
    $router->get('/notifications', 'SettingsController@notifications');
    $router->put('/notifications', 'SettingsController@updateNotifications');
});

// Notifications
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/notifications', 'NotificationController@index');
    $router->get('/notifications/unread', 'NotificationController@unread');
    $router->post('/notifications/{id}/read', 'NotificationController@markAsRead');
    $router->post('/notifications/read-all', 'NotificationController@markAllAsRead');
    $router->delete('/notifications/{id}', 'NotificationController@delete');
});

// Import/Export
$router->post('/export/users', 'ExportController@users');
$router->post('/export/posts', 'ExportController@posts');
$router->post('/export/data', 'ExportController@data');
$router->post('/import/users', 'ImportController@users');
$router->post('/import/bulk', 'ImportController@bulk');

// Webhooks
$router->post('/webhooks/github', 'WebhookController@github');
$router->post('/webhooks/stripe', 'WebhookController@stripe');
$router->post('/webhooks/slack', 'WebhookController@slack');

// File handling
$router->post('/upload', 'FileController@upload');
$router->get('/files/{id}', 'FileController@show');
$router->delete('/files/{id}', 'FileController@delete');

// Fallback
$router->fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
