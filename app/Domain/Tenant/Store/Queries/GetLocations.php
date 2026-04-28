<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Queries;

use App\Domain\Tenant\Store\Data\LocationData;
use App\Models\Dealer\Store;

class GetLocations
{
    /**
     * @var array<int, string>
     */
    private const array SELECT_COLUMNS = [
        'id',
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'phone',
        'website',
    ];

    /**
     * @return list<LocationData>
     */
    public function handle(): array
    {
        return Store::query()
            ->orderBy('name')
            ->get(self::SELECT_COLUMNS)
            ->map(static fn (Store $store): LocationData => LocationData::fromModel($store))
            ->values()
            ->all();
    }
}
