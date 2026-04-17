<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $storesExist = app()->bound('storesExist')
            ? (bool) resolve('storesExist')
            : Store::query()->exists();

        if ($storesExist) {
            return $next($request);
        }

        return to_route('dealer.dashboard');
    }
}
