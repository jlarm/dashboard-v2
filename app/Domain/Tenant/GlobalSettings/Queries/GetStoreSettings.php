<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Queries;

use App\Domain\Tenant\GlobalSettings\Data\StoreSettingData;
use App\Models\Dealer\Store;

class GetStoreSettings
{
    /**
     * @return list<StoreSettingData>
     */
    public function handle(): array
    {
        return Store::query()
            ->with('remediationSettings:id,store_id,active')
            ->orderBy('name')
            ->get(['id', 'name', 'courses_not_taken_notification'])
            ->map(static fn (Store $store): StoreSettingData => StoreSettingData::fromModel($store))
            ->values()
            ->all();
    }
}
