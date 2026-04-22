<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Queries;

use App\Domain\Tenant\Store\Data\StoreOptionData;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class GetAccessibleStoreOptions
{
    /**
     * @return Collection<int, StoreOptionData>
     */
    public function handle(User $user): Collection
    {
        return $this->fetchStores($user)
            ->map(StoreOptionData::fromModel(...))
            ->values();
    }

    /**
     * @return EloquentCollection<int, Store>
     */
    private function fetchStores(User $user): EloquentCollection
    {
        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get();
        }

        return $user->stores()
            ->select(['stores.id', 'stores.name'])
            ->orderBy('stores.name')
            ->get();
    }
}
