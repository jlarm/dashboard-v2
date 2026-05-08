<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;

class GeneralSectionData
{
    /**
     * @param  array{value: string, label: string}  ...$frequencies
     */
    public function __construct(
        public readonly StoreDetailsData $store,
        public readonly RemediationSettingsData $remediation,
        public readonly PhishingSettingsData $phishing,
        /** @var list<array{value: string, label: string}> */
        public readonly array $frequencies,
    ) {}

    /**
     * @param  list<array{value: string, label: string}>  $frequencies
     */
    public static function fromModels(Store $store, ?GlobalSetting $globalSetting, array $frequencies): self
    {
        return new self(
            store: StoreDetailsData::fromStore($store),
            remediation: RemediationSettingsData::fromStore($store),
            phishing: PhishingSettingsData::fromGlobalSetting($globalSetting),
            frequencies: $frequencies,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'store' => $this->store->toArray(),
            'remediation' => $this->remediation->toArray(),
            'phishing' => $this->phishing->toArray(),
            'frequencies' => $this->frequencies,
        ];
    }
}
