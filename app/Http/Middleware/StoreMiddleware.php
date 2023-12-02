<?php

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;

class StoreMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $storeSlug = $request->segment(2);

        $store = Store::where('slug', $storeSlug)->firstOrFail();

        $request->attributes->add(['store' => $store]);

        return $next($request);
    }
}
