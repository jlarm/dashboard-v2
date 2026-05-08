<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Manuals\Concerns;

use App\Domain\Tenant\Manuals\Queries\ResolveManualStores;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait ResolvesManualStore
{
    protected function resolveCurrentStore(): ?Store
    {
        $store = app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null;

        return $store instanceof Store ? $store : null;
    }

    protected function resolveCurrentStoreOrFail(): Store
    {
        $store = $this->resolveCurrentStore();

        abort_unless($store instanceof Store, 404);

        return $store;
    }

    /**
     * Abort with 404 unless the manual belongs to a store the user can scope to.
     * Hides existence of out-of-scope manuals rather than 403'ing.
     */
    protected function authorizeManualScope(Request $request, Model $manual): void
    {
        $user = $request->user();

        abort_unless($user instanceof User, 404);

        /** @var Collection<int, int> $storeIds */
        $storeIds = resolve(ResolveManualStores::class)->handle($user);

        abort_unless($storeIds->contains((int) $manual->getAttribute('store_id')), 404);
    }
}
