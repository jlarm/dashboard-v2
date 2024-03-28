<?php

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPhishingStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = Store::first()->phishing_is_enabled;

        $request->session()->put('phishing_is_enabled', $enabled);

        return $next($request);
    }
}
