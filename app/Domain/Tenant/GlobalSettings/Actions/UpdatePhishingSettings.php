<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Actions;

use App\Domain\Tenant\GlobalSettings\Data\UpdatePhishingSettingsData;
use App\Models\Dealer\GlobalSetting;

class UpdatePhishingSettings
{
    public function handle(UpdatePhishingSettingsData $data): void
    {
        GlobalSetting::query()->updateOrCreate([], [
            'phishing_active' => $data->active,
            'phishing_token' => $data->token,
            'phishing_ip' => $data->ip,
        ]);
    }
}
