<?php

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;

class CheckPhishingStatusMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $enabled = Store::first()->phishing_is_enabled;

        $request->session()->put('phishing_is_enabled', $enabled);

        return $next($request);
    }
}
