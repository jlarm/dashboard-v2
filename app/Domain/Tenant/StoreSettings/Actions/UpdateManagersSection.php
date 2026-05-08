<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Domain\Tenant\StoreSettings\Data\ManagersSectionData;
use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;

class UpdateManagersSection
{
    public function handle(Store $store, ManagersSectionData $data): void
    {
        EmployeeList::query()->updateOrCreate(
            ['store_id' => $store->id],
            $data->toArray(),
        );
    }
}
