<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsNotSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        if (tenant()->isSuspended()) {
            return response()->view('errors.tenant-suspended', [], 503);
        }

        return $next($request);
    }
}
