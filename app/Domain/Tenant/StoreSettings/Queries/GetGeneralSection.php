<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Queries;

use App\Domain\Tenant\StoreSettings\Data\GeneralSectionData;
use App\Enums\Frequency;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;

class GetGeneralSection
{
    public function handle(Store $store): GeneralSectionData
    {
        $store->loadMissing('remediationSettings');

        $globalSetting = GlobalSetting::query()->first();

        $frequencies = array_map(
            static fn (Frequency $frequency): array => [
                'value' => $frequency->value,
                'label' => $frequency->label(),
            ],
            Frequency::cases(),
        );

        return GeneralSectionData::fromModels($store, $globalSetting, $frequencies);
    }
}
