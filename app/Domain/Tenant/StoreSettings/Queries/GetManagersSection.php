<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Queries;

use App\Domain\Tenant\StoreSettings\Data\ManagersSectionData;
use App\Models\Dealer\Store;

class GetManagersSection
{
    public function handle(Store $store): ManagersSectionData
    {
        return ManagersSectionData::fromStore($store);
    }
}
