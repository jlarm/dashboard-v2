<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\ManualsSummaryData;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;

class GetManualsSummary
{
    /**
     * Whether each manual type has at least one signed record for the
     * given store. A signed manual is created when the store completes the
     * adoption form, so existence is the right proxy for "active".
     */
    public function handleForStore(Store $store): ManualsSummaryData
    {
        return new ManualsSummaryData(
            isp: Isp::query()->where('store_id', $store->id)->exists(),
            osha: Osha::query()->where('store_id', $store->id)->exists(),
            red_flag: RedFlag::query()->where('store_id', $store->id)->exists(),
            cms: CmsManual::query()->where('store_id', $store->id)->exists(),
        );
    }
}
