<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Data;

use App\Enums\State;

final readonly class CreateStoreData
{
    public function __construct(
        public string $name,
        public string $address,
        public string $city,
        public State $state,
        public string $postalCode,
        public string $phone,
        public string $website,
    ) {}

    /**
     * @return array{name: string, address: string, city: string, state: string, postal_code: string, phone: string, website: string}
     */
    public function toStoreCreatorPayload(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state->value,
            'postal_code' => $this->postalCode,
            'phone' => $this->phone,
            'website' => $this->website,
        ];
    }
}
