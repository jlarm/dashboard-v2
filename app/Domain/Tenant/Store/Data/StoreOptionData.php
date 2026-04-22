<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Data;

use App\Models\Dealer\Store;

final readonly class StoreOptionData
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}

    public static function fromModel(Store $store): self
    {
        return new self(
            id: (int) $store->id,
            name: (string) $store->name,
        );
    }

    /**
     * @return array{id: int, name: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
