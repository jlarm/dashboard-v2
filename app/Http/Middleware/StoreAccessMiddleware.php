<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->stores()->where('id', $request->route('store'))->exists()) {
            return $next($request);
        }
    }
}
