<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StoreAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->stores()->where('id', $request->route('store'))->exists()) {
            return $next($request);
        }
    }
}
