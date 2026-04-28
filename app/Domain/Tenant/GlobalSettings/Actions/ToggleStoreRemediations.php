<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Actions;

use App\Models\Dealer\Store;

class ToggleStoreRemediations
{
    public function handle(Store $store): void
    {
        $current = (bool) $store->remediationSettings?->active;

        $store->remediationSettings()->updateOrCreate([], ['active' => ! $current]);
    }
}
