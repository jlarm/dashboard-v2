<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant\Audit\Concerns;

use App\Domain\Tenant\Audits\Queries\ResolveAuditScopedStores;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ResolvesAuditScope
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
     * @return Collection<int, int>
     */
    protected function scopedStoreIds(): Collection
    {
        return resolve(ResolveAuditScopedStores::class)->handle();
    }

    /**
     * Hide audits outside the current scope rather than 403 — same pattern as ResolvesManualStore.
     */
    protected function authorizeAuditScope(ViolationAudit&Model $audit): void
    {
        $storeIds = $this->scopedStoreIds();

        abort_unless($storeIds->contains((int) $audit->store_id), 404);
    }
}
