<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Dealer\Store;
use Illuminate\Support\Collection;

trait ResolvesDashboardStore
{
    protected function resolveDashboardStore(): ?Store
    {
        if (app()->bound('currentStoreModel') && app('currentStoreModel') instanceof Store) {
            return app('currentStoreModel');
        }

        $storeId = $this->resolveDashboardStoreId();

        if ($storeId === null) {
            return null;
        }

        return Store::query()->whereKey($storeId)->first();
    }

    protected function resolveDashboardStoreId(): ?int
    {
        if (app()->bound('currentStore')) {
            $currentStoreId = app('currentStore');

            if (is_numeric($currentStoreId) && (int) $currentStoreId > 0) {
                return (int) $currentStoreId;
            }
        }

        return $this->resolveSingleBoundStoreId('scopedStoreIds')
            ?? $this->resolveSingleBoundStoreId('accessibleStoreIds');
    }

    private function resolveSingleBoundStoreId(string $binding): ?int
    {
        if (! app()->bound($binding)) {
            return null;
        }

        $storeIds = app($binding);

        if (! $storeIds instanceof Collection) {
            $storeIds = collect($storeIds);
        }

        $normalizedStoreIds = $storeIds
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => $id > 0)
            ->unique()
            ->values();

        if ($normalizedStoreIds->count() !== 1) {
            return null;
        }

        return (int) $normalizedStoreIds->first();
    }
}
