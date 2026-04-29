<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ScanSettingsData;
use App\Models\Dealer\Store;

class GetScanSettings
{
    public function handle(Store $store): ScanSettingsData
    {
        $store->loadMissing('cyrisma');

        return ScanSettingsData::fromStore($store);
    }
}
