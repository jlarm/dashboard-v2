<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleStoreMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! tenant('locations')) {
            return $next($request);
        }

        return redirect()->route('dealer.dashboard');
    }
}
