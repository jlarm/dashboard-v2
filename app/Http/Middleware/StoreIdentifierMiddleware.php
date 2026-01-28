<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;

class StoreIdentifierMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! tenant()) {
            return $next($request);
        }

        if (! Store::exists($request->store)) {
            return $next($request);
        }

        $path = $request->path();
        $segments = explode('/', $path);

        if (count($segments) > 1 && $segments[0] === 'stores') {
            $storeSlug = $segments[1];
            $store = Store::where('slug', $storeSlug)->firstOrFail()->id;
        } else {
            $store = Store::first()->id;
        }

        app()->instance('currentStore', $store);

        return $next($request);
    }
}
