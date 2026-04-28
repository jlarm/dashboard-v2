<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Queries;

use App\Domain\Tenant\GlobalSettings\Data\PhishingSettingsData;
use App\Models\Dealer\GlobalSetting;

class GetPhishingSettings
{
    public function handle(): PhishingSettingsData
    {
        return PhishingSettingsData::fromModel(GlobalSetting::query()->first());
    }
}
