<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Domain\Tenant\StoreSettings\Data\ComplianceSectionData;
use App\Models\Dealer\Store;

class UpdateComplianceSection
{
    public function handle(Store $store, ComplianceSectionData $data): void
    {
        $store->update($data->toArray());
    }
}
