<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Dealer\Store;
use App\Services\StoreScopeService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

class StoreIdentifierMiddleware
{
    public function __construct(private readonly StoreScopeService $storeScopeService) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! tenant()) {
            return $next($request);
        }

        $user = $request->user();

        if (! $user) {
            $this->setCurrentStoreContext(null, collect(), collect());

            return $next($request);
        }

        if ($request->route()?->named('dealer.legacy-stores.redirect')) {
            $accessibleStoreIds = $this->storeScopeService->accessibleStoreIds($user);
            $scopedStoreIds = $this->storeScopeService->scopedStoreIds($user);

            $this->setCurrentStoreContext(null, $accessibleStoreIds, $scopedStoreIds);

            return $next($request);
        }

        $store = $this->storeScopeService->normalizeSelectedStore($user);
        $accessibleStoreIds = $this->storeScopeService->accessibleStoreIds($user);
        $scopedStoreIds = $this->storeScopeService->scopedStoreIds($user);

        $this->setCurrentStoreContext($store, $accessibleStoreIds, $scopedStoreIds);

        return $next($request);
    }

    /**
     * @param  Collection<int, int>  $accessibleStoreIds
     * @param  Collection<int, int>  $scopedStoreIds
     */
    private function setCurrentStoreContext(?Store $store, Collection $accessibleStoreIds, Collection $scopedStoreIds): void
    {
        app()->instance('currentStore', $store?->id);
        app()->instance('accessibleStoreIds', $accessibleStoreIds->map(static fn (mixed $id): int => (int) $id)->values());
        app()->instance('scopedStoreIds', $scopedStoreIds->map(static fn (mixed $id): int => (int) $id)->values());

        if ($store instanceof Store) {
            app()->instance('currentStoreModel', $store);

            return;
        }

        app()->forgetInstance('currentStoreModel');
    }
}
