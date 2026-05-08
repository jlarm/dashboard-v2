<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Queries;

use App\Domain\Tenant\StoreSettings\Data\ComplianceSectionData;
use App\Models\Dealer\Store;

class GetComplianceSection
{
    public function handle(Store $store): ComplianceSectionData
    {
        return ComplianceSectionData::fromStore($store);
    }
}
