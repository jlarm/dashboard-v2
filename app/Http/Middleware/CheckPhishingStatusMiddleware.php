<?php

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class CheckPhishingStatusMiddleware
{
    protected Tenancy $tenancy;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->tenancy->initialized) {
            $enabled = Store::first()->phishing_is_enabled;
            $request->session()->put('phishing_is_enabled', $enabled);
        }

        return $next($request);
    }
}
