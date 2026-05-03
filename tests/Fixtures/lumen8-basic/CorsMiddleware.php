<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\AuthService;

/**
 * Custom CORS Middleware for Lumen 8
 * Approximately 300 lines of code for testing AST parsing.
 * Handles preflight requests, origin validation, and CORS headers.
 */
class CorsMiddleware
{
    protected AuthService $authService;
    protected array $allowedOrigins;
    protected array $allowedMethods;
    protected array $allowedHeaders;
    protected array $exposedHeaders;
    protected int $maxAge;
    protected bool $credentialsAllowed;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->allowedOrigins = config('cors.allowed_origins', ['*']);
        $this->allowedMethods = config('cors.allowed_methods', ['GET', 'POST', 'PUT', 'DELETE', 'PATCH']);
        $this->allowedHeaders = config('cors.allowed_headers', ['Content-Type', 'Authorization']);
        $this->exposedHeaders = config('cors.expose_headers', ['X-Total-Count', 'X-Page-Number']);
        $this->maxAge = config('cors.max_age', 86400);
        $this->credentialsAllowed = config('cors.credentials_allowed', true);
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Check if CORS is enabled
        if (!config('cors.enabled', true)) {
            return $next($request);
        }

        // Log incoming request for monitoring
        $this->logCorsActivity($request, 'request_received');

        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return $this->handlePreflight($request);
        }

        // Add CORS headers to response
        $response = $next($request);
        return $this->addCorsHeaders($request, $response);
    }

    protected function handlePreflight(Request $request): Response
    {
        // Validate origin
        $origin = $request->header('Origin');
        if (!$this->isOriginAllowed($origin)) {
            Log::warning('CORS preflight rejected: origin not allowed', [
                'origin' => $origin,
                'ip' => $request->ip(),
                'timestamp' => now(),
            ]);
            return response()->json(['error' => 'CORS policy: Origin not allowed'], 403);
        }

        // Validate request method
        $method = $request->header('Access-Control-Request-Method');
        if (!$this->isMethodAllowed($method)) {
            Log::warning('CORS preflight rejected: method not allowed', [
                'method' => $method,
                'origin' => $origin,
                'timestamp' => now(),
            ]);
            return response()->json(['error' => 'CORS policy: Method not allowed'], 403);
        }

        // Validate request headers
        $headers = $request->header('Access-Control-Request-Headers');
        if (!$this->areHeadersAllowed($headers)) {
            Log::warning('CORS preflight rejected: headers not allowed', [
                'headers' => $headers,
                'origin' => $origin,
                'timestamp' => now(),
            ]);
            return response()->json(['error' => 'CORS policy: Headers not allowed'], 403);
        }

        // Log successful preflight
        $this->logCorsActivity($request, 'preflight_accepted', [
            'method' => $method,
            'headers_requested' => $headers,
        ]);

        // Return successful preflight response
        return response('', 200)
            ->header('Access-Control-Allow-Origin', $origin)
            ->header('Access-Control-Allow-Methods', implode(', ', $this->allowedMethods))
            ->header('Access-Control-Allow-Headers', implode(', ', $this->allowedHeaders))
            ->header('Access-Control-Allow-Credentials', $this->credentialsAllowed ? 'true' : 'false')
            ->header('Access-Control-Max-Age', $this->maxAge)
            ->header('Vary', 'Origin, Access-Control-Request-Method, Access-Control-Request-Headers');
    }

    protected function addCorsHeaders(Request $request, Response $response): Response
    {
        $origin = $request->header('Origin');
        
        if ($this->isOriginAllowed($origin)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Credentials', $this->credentialsAllowed ? 'true' : 'false');
            
            if (!empty($this->exposedHeaders)) {
                $response->header('Access-Control-Expose-Headers', implode(', ', $this->exposedHeaders));
            }
            
            $response->header('Vary', 'Origin');
        }

        return $response;
    }

    protected function isOriginAllowed(?string $origin): bool
    {
        if (in_array('*', $this->allowedOrigins)) {
            return true;
        }

        if ($origin === null) {
            return false;
        }

        // Check cache for performance optimization
        $cacheKey = "cors_origin_allowed_{$origin}";
        $cached = Cache::get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $allowed = false;

        foreach ($this->allowedOrigins as $allowedOrigin) {
            if ($origin === $allowedOrigin) {
                $allowed = true;
                break;
            }
            
            // Support for wildcard subdomains
            if (str_starts_with($allowedOrigin, '*.') && str_ends_with($origin, substr($allowedOrigin, 1))) {
                $allowed = true;
                break;
            }
        }

        // Cache the result for 1 hour
        Cache::put($cacheKey, $allowed, 3600);

        return $allowed;
    }

    protected function isMethodAllowed(?string $method): bool
    {
        if ($method === null) {
            return false;
        }

        return in_array(strtoupper($method), array_map('strtoupper', $this->allowedMethods));
    }

    protected function areHeadersAllowed(?string $headers): bool
    {
        if ($headers === null) {
            return true; // No headers requested is allowed
        }

        $requestedHeaders = array_map('trim', explode(',', $headers));
        
        foreach ($requestedHeaders as $header) {
            $headerLower = strtolower($header);
            $isAllowed = false;
            
            foreach ($this->allowedHeaders as $allowed) {
                if (strtolower($allowed) === $headerLower) {
                    $isAllowed = true;
                    break;
                }
            }
            
            if (!$isAllowed) {
                return false;
            }
        }

        return true;
    }

    /**
     * Log CORS activity for monitoring
     */
    protected function logCorsActivity(Request $request, string $action, array $context = []): void
    {
        $context = array_merge($context, [
            'origin' => $request->header('Origin'),
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'timestamp' => now()->toIso8601String(),
        ]);

        Log::info("CORS {$action}", $context);
    }

    /**
     * Get CORS configuration for debugging
     */
    public function getConfig(): array
    {
        return [
            'enabled' => config('cors.enabled', true),
            'allowed_origins' => $this->allowedOrigins,
            'allowed_methods' => $this->allowedMethods,
            'allowed_headers' => $this->allowedHeaders,
            'expose_headers' => $this->exposedHeaders,
            'max_age' => $this->maxAge,
            'credentials_allowed' => $this->credentialsAllowed,
        ];
    }

    /**
     * Validate CORS configuration
     */
    public function validateConfiguration(): array
    {
        $errors = [];

        if (empty($this->allowedOrigins)) {
            $errors[] = 'No allowed origins configured';
        }

        if (empty($this->allowedMethods)) {
            $errors[] = 'No allowed methods configured';
        }

        if ($this->maxAge < 0) {
            $errors[] = 'Max age cannot be negative';
        }

        return $errors;
    }

    /**
     * Clear CORS cache for a specific origin
     */
    public function clearOriginCache(string $origin): bool
    {
        $cacheKey = "cors_origin_allowed_{$origin}";
        return Cache::forget($cacheKey);
    }

    /**
     * Add a new allowed origin dynamically
     */
    public function addAllowedOrigin(string $origin): void
    {
        if (!in_array($origin, $this->allowedOrigins)) {
            $this->allowedOrigins[] = $origin;
            $this->clearOriginCache($origin);
        }
    }

    /**
     * Remove an allowed origin
     */
    public function removeAllowedOrigin(string $origin): void
    {
        $this->allowedOrigins = array_filter(
            $this->allowedOrigins,
            fn($o) => $o !== $origin
        );
        $this->clearOriginCache($origin);
    }

    /**
     * Check if a specific origin is blocked
     */
    public function isOriginBlocked(string $origin): bool
    {
        $blocklist = config('cors.blocklist', []);
        return in_array($origin, $blocklist);
    }

    /**
     * Get all CORS statistics for debugging and monitoring
     */
    public function getStatistics(): array
    {
        $cacheKey = 'cors_statistics';
        $stats = Cache::get($cacheKey, [
            'preflight_count' => 0,
            'successful_requests' => 0,
            'failed_requests' => 0,
            'blocked_origins' => [],
        ]);

        return $stats;
    }

    /**
     * Reset CORS statistics
     */
    public function resetStatistics(): void
    {
        Cache::forget('cors_statistics');
    }

    /**
     * Format origin for display purposes
     */
    private function formatOrigin(string $origin): string
    {
        return mb_strtolower($origin);
    }

    /**
     * Parse origin components (scheme, host, port)
     */
    private function parseOrigin(string $origin): array
    {
        $parts = parse_url($origin);
        return [
            'scheme' => $parts['scheme'] ?? null,
            'host' => $parts['host'] ?? null,
            'port' => $parts['port'] ?? null,
            'full' => $origin,
        ];
    }

    /**
     * Validate that headers match CORS requirements
     */
    private function validateHeadersFormat(string $headers): bool
    {
        $parts = explode(',', $headers);
        foreach ($parts as $header) {
            $trimmed = trim($header);
            if (empty($trimmed) || !preg_match('/^[a-zA-Z0-9\-]+$/', $trimmed)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Validate that methods are standard HTTP methods
     */
    private function validateMethods(array $methods): bool
    {
        $valid = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'HEAD', 'OPTIONS'];
        foreach ($methods as $method) {
            if (!in_array(strtoupper($method), $valid)) {
                return false;
            }
        }
        return true;
    }
}
