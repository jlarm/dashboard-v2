<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SingleStoreMiddleware
{
    // Check if current tenant is a single store
    // Used in the tenant.php routes file

    public function handle(Request $request, Closure $next): Response
    {
        if (! tenant('locations')) {
            return $next($request);
        }

        return redirect()->route('dealer.dashboard');
    }
}
