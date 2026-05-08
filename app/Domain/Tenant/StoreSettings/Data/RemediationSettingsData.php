<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\Store;
use App\Models\RemediationSetting;

class RemediationSettingsData
{
    public function __construct(
        public readonly bool $active,
        public readonly bool $notifications,
        public readonly ?string $frequency,
    ) {}

    public static function fromStore(Store $store): self
    {
        $settings = $store->remediationSettings;

        return new self(
            active: $settings instanceof RemediationSetting ? (bool) $settings->active : false,
            notifications: $settings instanceof RemediationSetting ? (bool) $settings->notifications : false,
            frequency: $settings instanceof RemediationSetting ? $settings->frequency?->value : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'active' => $this->active,
            'notifications' => $this->notifications,
            'frequency' => $this->frequency,
        ];
    }
}
