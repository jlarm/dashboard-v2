<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Actions;

use App\Domain\Tenant\Store\Data\UpdateStoreData;
use App\Models\Dealer\Store;

class UpdateStore
{
    public function handle(Store $store, UpdateStoreData $data): void
    {
        $store->update($data->toAttributes());
    }
}
