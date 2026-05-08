<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\GlobalSetting;

class PhishingSettingsData
{
    public function __construct(
        public readonly bool $active,
        public readonly ?string $token,
        public readonly ?string $ip,
    ) {}

    public static function fromGlobalSetting(?GlobalSetting $setting): self
    {
        return new self(
            active: $setting instanceof GlobalSetting ? (bool) $setting->phishing_active : false,
            token: $setting?->phishing_token,
            ip: $setting?->phishing_ip,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'active' => $this->active,
            'token' => $this->token,
            'ip' => $this->ip,
        ];
    }
}
