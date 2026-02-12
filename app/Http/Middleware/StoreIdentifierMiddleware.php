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

        $path = $request->path();
        $segments = explode('/', $path);

        if (count($segments) > 1 && $segments[0] === 'stores') {
            $storeModel = Store::query()->where('slug', $segments[1])->firstOrFail();
        } else {
            $storeModel = Store::query()->first();
        }

        if (! $storeModel) {
            return $next($request);
        }

        app()->instance('currentStore', $storeModel->id);
        app()->instance('currentStoreModel', $storeModel);

        return $next($request);
    }
}
