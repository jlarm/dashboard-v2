<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Queries;

use App\Domain\Tenant\Manuals\Cms\Data\CmsFormDefaultsData;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class BuildCmsFormDefaults
{
    public function handle(Store $store): CmsFormDefaultsData
    {
        $now = now();

        return new CmsFormDefaultsData(
            storeId: (int) $store->id,
            storeName: (string) $store->name,
            tenantName: (string) (tenant('name') ?? $store->name),
            qualifiedIndividualName: $this->resolveQualifiedIndividualName($store),
            standardDppRate: $store->standard_dpp_rate !== null
                ? (string) $store->standard_dpp_rate
                : null,
            today: $now->format('F j, Y'),
            todayDay: $now->format('jS'),
            todayMonth: $now->format('F'),
            todayYear: $now->format('Y'),
        );
    }

    private function resolveQualifiedIndividualName(Store $store): ?string
    {
        $multipleStoresExist = app()->bound('multipleStoresExist') && (bool) resolve('multipleStoresExist');

        if ($multipleStoresExist) {
            return User::query()
                ->whereHas('roles', static fn (Builder $query) => $query->where('name', 'Qualified Individual'))
                ->whereHas('stores', static fn (Builder $query) => $query->where('store_id', $store->id))
                ->value('name');
        }

        return User::query()->role('Qualified Individual')->value('name');
    }
}
