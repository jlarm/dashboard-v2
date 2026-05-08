<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Data;

use App\Models\Dealer\Store;

class StoreDetailsData
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly ?string $address,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $postal_code,
        public readonly ?string $phone,
        public readonly ?string $website,
        public readonly bool $courses_not_taken_notification,
        public readonly bool $videos,
    ) {}

    public static function fromStore(Store $store): self
    {
        return new self(
            id: $store->id,
            name: (string) $store->name,
            address: $store->address,
            city: $store->city,
            state: $store->state,
            postal_code: $store->postal_code,
            phone: $store->phone,
            website: $store->website,
            courses_not_taken_notification: (bool) $store->courses_not_taken_notification,
            videos: (bool) $store->videos,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'website' => $this->website,
            'courses_not_taken_notification' => $this->courses_not_taken_notification,
            'videos' => $this->videos,
        ];
    }
}
