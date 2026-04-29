<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Resolves which stores the given user may see in the scans area.
 *
 * Returns either a single-store collection (focused dashboard) or a
 * many-store collection (multi-store overview).
 */
class ResolveScannableStores
{
    /**
     * @return Collection<int, int>
     */
    public function handle(?User $user): Collection
    {
        if (app()->bound('scopedStoreIds')) {
            /** @var Collection<int, mixed> $storeIds */
            $storeIds = resolve('scopedStoreIds');

            $normalized = $storeIds->map(static fn ($id): int => (int) $id)->values();

            if ($normalized->isNotEmpty()) {
                return $normalized;
            }
        }

        if (! $user instanceof User) {
            return collect();
        }

        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return $user->current_store_id !== null
                ? collect([(int) $user->current_store_id])
                : Store::query()->pluck('id')->map(static fn ($id): int => (int) $id)->values();
        }

        $assignedStoreIds = $user->stores()
            ->pluck('stores.id')
            ->map(static fn ($id): int => (int) $id);

        if ($user->current_store_id === null) {
            return $assignedStoreIds->values();
        }

        if ($assignedStoreIds->contains($user->current_store_id)) {
            return collect([(int) $user->current_store_id]);
        }

        return collect();
    }
}
