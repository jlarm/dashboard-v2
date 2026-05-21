<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Collection;

class StoreScopeService
{
    /**
     * @var array<int, Collection<int, int>>
     */
    private array $accessibleStoreIdsCache = [];

    /**
     * @var array<int, Store|null>
     */
    private array $selectedStoreCache = [];

    /**
     * @return Collection<int, int>
     */
    public function accessibleStoreIds(?User $user): Collection
    {
        if (! $user instanceof User) {
            return collect();
        }

        if (isset($this->accessibleStoreIdsCache[$user->id])) {
            return $this->accessibleStoreIdsCache[$user->id];
        }

        $allStoreIds = Store::query()->pluck('id');

        if ($allStoreIds->count() <= 1) {
            return $this->accessibleStoreIdsCache[$user->id] = $allStoreIds;
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $this->accessibleStoreIdsCache[$user->id] = $allStoreIds;
        }

        return $this->accessibleStoreIdsCache[$user->id] = $user->stores()->pluck('stores.id');
    }

    /**
     * @return Collection<int, int>
     */
    public function scopedStoreIds(?User $user): Collection
    {
        if (! $user instanceof User) {
            return collect();
        }

        $accessibleStoreIds = $this->accessibleStoreIds($user);

        if ($user->current_store_id === null) {
            return $accessibleStoreIds->values();
        }

        if ($accessibleStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }

    public function selectedStore(?User $user): ?Store
    {
        if (! $user instanceof User || $user->current_store_id === null) {
            return null;
        }

        if (array_key_exists($user->id, $this->selectedStoreCache)) {
            return $this->selectedStoreCache[$user->id];
        }

        return $this->selectedStoreCache[$user->id] = Store::query()
            ->whereKey($user->current_store_id)
            ->first();
    }

    public function normalizeSelectedStore(User $user): ?Store
    {
        $accessibleStoreIds = $this->accessibleStoreIds($user)->map(static fn (mixed $id): int => (int) $id)->values();

        if ($user->current_store_id === null) {
            return $this->autoSelectSingleAccessibleStore($user, $accessibleStoreIds);
        }

        $selectedStore = $this->selectedStore($user);

        if (! $selectedStore instanceof Store) {
            return $this->resetOrAutoSelectSingleStore($user, $accessibleStoreIds);
        }

        if ($accessibleStoreIds->doesntContain($selectedStore->id)) {
            return $this->resetOrAutoSelectSingleStore($user, $accessibleStoreIds);
        }

        return $selectedStore;
    }

    /**
     * @param  Collection<int, int>  $accessibleStoreIds
     */
    private function autoSelectSingleAccessibleStore(User $user, Collection $accessibleStoreIds): ?Store
    {
        if (! $this->shouldAutoSelectSingleAccessibleStore($user)) {
            return null;
        }

        if ($accessibleStoreIds->count() !== 1) {
            return null;
        }

        $storeId = (int) $accessibleStoreIds->first();
        $store = Store::query()->whereKey($storeId)->first();

        if (! $store instanceof Store) {
            return null;
        }

        $user->update(['current_store_id' => $store->id]);

        return $store;
    }

    /**
     * @param  Collection<int, int>  $accessibleStoreIds
     */
    private function resetOrAutoSelectSingleStore(User $user, Collection $accessibleStoreIds): ?Store
    {
        $store = $this->autoSelectSingleAccessibleStore($user, $accessibleStoreIds);

        if ($store instanceof Store) {
            return $store;
        }

        $user->update(['current_store_id' => null]);

        return null;
    }

    private function shouldAutoSelectSingleAccessibleStore(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }
}
