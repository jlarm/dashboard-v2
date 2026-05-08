<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Enums\Frequency;

class UpdateGeneralData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $postal_code,
        public readonly ?string $phone,
        public readonly ?string $website,
        public readonly bool $courses_not_taken_notification,
        public readonly bool $remediations_active,
        public readonly bool $remediation_notifications,
        public readonly ?Frequency $remediation_frequency,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function storeAttributes(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
            'courses_not_taken_notification' => $this->courses_not_taken_notification,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function remediationAttributes(): array
    {
        return [
            'active' => $this->remediations_active,
            'notifications' => $this->remediation_notifications,
            'frequency' => $this->remediation_frequency?->value,
        ];
    }
}
