<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireTenantStoreMiddleware
{
    /**
     * @var array<int, string>
     */
    private const array ALLOWED_ROUTE_NAMES = [
        'dealer.dashboard',
        'dealer.store.first',
        'dealer.logout',
        'dealer.stop.impersonation',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        $storeCount = Store::query()->count();
        $storesExist = $storeCount > 0;
        $multipleStoresExist = $storeCount > 1;
        app()->instance('storesExist', $storesExist);
        app()->instance('multipleStoresExist', $multipleStoresExist);
        app()->instance('globalSetting', GlobalSetting::query()->first());

        if ($storesExist) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();

        if (is_string($routeName) && in_array($routeName, self::ALLOWED_ROUTE_NAMES, true)) {
            return $next($request);
        }

        return to_route('dealer.dashboard');
    }
}
