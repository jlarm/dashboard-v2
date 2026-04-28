<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Data;

use App\Models\Dealer\Store;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class LocationData implements Arrayable
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $address,
        public ?string $city,
        public ?string $state,
        public ?string $postalCode,
        public ?string $phone,
        public ?string $website,
    ) {}

    public static function fromModel(Store $store): self
    {
        return new self(
            id: (int) $store->id,
            name: (string) $store->name,
            address: $store->address,
            city: $store->city,
            state: $store->state,
            postalCode: $store->postal_code,
            phone: $store->phone,
            website: $store->website,
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     address: string|null,
     *     city: string|null,
     *     state: string|null,
     *     postal_code: string|null,
     *     phone: string|null,
     *     website: string|null
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postalCode,
            'phone' => $this->phone,
            'website' => $this->website,
        ];
    }
}
