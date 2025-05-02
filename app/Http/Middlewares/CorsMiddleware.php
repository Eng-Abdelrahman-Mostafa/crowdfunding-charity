<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // For OPTIONS requests (preflight), return early with headers
        if ($request->isMethod('OPTIONS')) {
            $response = new Response('', 200);
        } else {
            $response = $next($request);
        }

        // Get the origin from the request
        $origin = $request->header('Origin');

        if ($origin) {
            // Apply headers to all responses including OPTIONS
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            // In CorsMiddleware.php
            $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Auth-Token, Origin, Authorization, X-XSRF-TOKEN, X-CSRF-TOKEN, Accept, X-HTTP-Method-Override, Cache-Control, cache-control');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
            $response->headers->set('Access-Control-Max-Age', '86400'); // 24 hours cache
            $response->headers->set('Vary', 'Origin'); // Important for caching with multiple origins
        }

        return $response;
    }
}
