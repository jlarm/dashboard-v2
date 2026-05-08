<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Data;

use App\Models\Dealer\GlobalSetting;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class PhishingSettingsData implements Arrayable
{
    public function __construct(
        public bool $active,
        public ?string $token,
        public ?string $ip,
    ) {}

    public static function fromModel(?GlobalSetting $settings): self
    {
        if ($settings === null) {
            return new self(active: false, token: null, ip: null);
        }

        return new self(
            active: (bool) $settings->phishing_active,
            token: $settings->phishing_token,
            ip: $settings->phishing_ip,
        );
    }

    /**
     * @return array{active: bool, token: string|null, ip: string|null}
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
