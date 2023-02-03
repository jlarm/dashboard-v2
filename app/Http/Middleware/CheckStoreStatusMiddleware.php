<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStoreStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (tenant('locations')) {
            return $next($request);
        }

        return redirect()->route('dealer.dashboard');
    }
}
