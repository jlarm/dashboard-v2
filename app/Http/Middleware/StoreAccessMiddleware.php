<?php

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->hasAnyRole(['super-admin', 'Consultant'])) {
            return $next($request);
        }

        $storeSlug = explode('/', $request->path())[1] ?? null;
        $store = Store::where('slug', $storeSlug)->first();

        if (! $store || ! $request->user()->stores()->where('id', $store->id)->exists()) {
            return redirect()->route('dealer.dashboard');
        }

        return $next($request);
    }
}
