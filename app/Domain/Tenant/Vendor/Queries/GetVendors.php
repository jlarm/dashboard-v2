<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Queries;

use App\Domain\Tenant\Vendor\Data\VendorListData;
use App\Models\Dealer\Vendor;
use App\Models\User;
use App\Services\StoreScopeService;
use Illuminate\Database\Eloquent\Builder;

class GetVendors
{
    public function __construct(private readonly StoreScopeService $storeScopeService) {}

    /**
     * @return list<VendorListData>
     */
    public function handle(?User $viewer): array
    {
        $scopedStoreIds = $this->storeScopeService->scopedStoreIds($viewer);

        return Vendor::query()
            ->with(['store:id,name', 'latestForm'])
            ->where(function (Builder $query) use ($scopedStoreIds): void {
                if ($scopedStoreIds->isNotEmpty()) {
                    $query->whereIn('store_id', $scopedStoreIds);
                }

                $query->orWhereNull('store_id');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'contact_name', 'contact_email', 'store_id', 'signature', 'created_at'])
            ->map(static fn (Vendor $vendor): VendorListData => VendorListData::fromModel($vendor))
            ->values()
            ->all();
    }
}
