<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Domain\Tenant\StoreSettings\Data\UpdateGeneralData;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\DB;

class UpdateGeneralSection
{
    public function handle(Store $store, UpdateGeneralData $data): void
    {
        DB::transaction(function () use ($store, $data): void {
            $store->update($data->storeAttributes());

            $store->remediationSettings()->updateOrCreate([], $data->remediationAttributes());
        });
    }
}
