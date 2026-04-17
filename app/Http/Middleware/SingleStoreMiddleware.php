<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class SingleStoreMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Collection<int, int> $scopedStoreIds */
        $scopedStoreIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();
        $currentStoreId = app()->bound('currentStore') ? resolve('currentStore') : null;

        if ($currentStoreId !== null || $scopedStoreIds->count() <= 1) {
            return $next($request);
        }

        return to_route('dealer.dashboard');
    }
}
