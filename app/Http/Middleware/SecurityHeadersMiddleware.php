<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'DENY');

        $response->headers->set('X-XSS-Protection', '1; mode=block');

        $response->headers->set('X-Content-Type-Options', 'nosniff');

        $response->headers->set('Referrer-Policy', 'same-origin');

        $response->headers->set('Permissions-Policy', 'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()');

        return $response;
    }
}
