<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $storeSlug = $request->segment(2);

        $store = Store::where('slug', $storeSlug)->firstOrFail();

        $request->attributes->add(['store' => $store]);

        return $next($request);
    }
}
