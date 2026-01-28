<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (tenant('locations')) {
            return $next($request);
        }

        return redirect()->route('dealer.dashboard');
    }
}
