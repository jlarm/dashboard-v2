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

        \Session::put('stores', $store->name);

        return $next($request);
    }
}
