<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Queries;

use App\Models\Dealer\Store;
use App\Models\User;

class GetVendorIndexOptions
{
    /**
     * @return array{
     *     stores: list<array{id: int, name: string}>,
     *     multipleStoresExist: bool,
     *     hasQualifiedIndividual: bool
     * }
     */
    public function handle(): array
    {
        $stores = Store::query()->orderBy('name')->get(['id', 'name']);
        $multipleStoresExist = $stores->count() > 1;

        return [
            'stores' => $multipleStoresExist
                ? $stores->map(static fn (Store $store): array => [
                    'id' => (int) $store->id,
                    'name' => (string) $store->name,
                ])->values()->all()
                : [],
            'multipleStoresExist' => $multipleStoresExist,
            'hasQualifiedIndividual' => User::query()->role('Qualified Individual')->exists(),
        ];
    }
}
