<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Queries;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Resolves which stores the user may see manuals for. Mirrors the
 * scoping rules used by the scans domain — returns either a single
 * focused store or the multi-store overview set.
 */
class ResolveManualStores
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
