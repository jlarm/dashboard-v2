<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Cache;
use Closure;
use Illuminate\Http\Request;

class CheckPhishingStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = Cache::remember('phishing_is_enabled', now()->addMinutes(10), function () {
            return Store::first()->phishing_is_enabled;
        });

        $request->session()->put('phishing_is_enabled', $enabled);

        return $next($request);
    }
}
