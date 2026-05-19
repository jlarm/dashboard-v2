<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use Illuminate\Support\Collection;

class ResolveAuditScopedStores
{
    /**
     * @return Collection<int, int>
     */
    public function handle(): Collection
    {
        if (! app()->bound('scopedStoreIds')) {
            return collect();
        }

        /** @var Collection<int, mixed> $storeIds */
        $storeIds = resolve('scopedStoreIds');

        return $storeIds->map(static fn (mixed $id): int => (int) $id)->values();
    }
}
