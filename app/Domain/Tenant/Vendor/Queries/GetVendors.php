<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Vendor\Queries;

use App\Domain\Tenant\Vendor\Data\VendorListData;
use App\Models\Dealer\Vendor;
use App\Models\User;
use App\Services\StoreScopeService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetVendors
{
    private const int PER_PAGE = 16;

    public function __construct(private readonly StoreScopeService $storeScopeService) {}

    public function handle(?User $viewer, string $search = '', int $page = 1): LengthAwarePaginator
    {
        $scopedStoreIds = $this->storeScopeService->scopedStoreIds($viewer);
        $search = mb_trim($search);

        $paginator = Vendor::query()
            ->with(['store:id,name', 'latestForm'])
            ->where(function (Builder $query) use ($scopedStoreIds): void {
                if ($scopedStoreIds->isNotEmpty()) {
                    $query->whereIn('store_id', $scopedStoreIds);
                }

                $query->orWhereNull('store_id');
            })
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('contact_name', 'like', "%{$search}%")
                        ->orWhere('contact_email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(
                perPage: self::PER_PAGE,
                columns: ['id', 'name', 'contact_name', 'contact_email', 'store_id', 'signature', 'created_at'],
                page: $page,
            );

        $paginator->setCollection(
            $paginator->getCollection()->map(
                static fn (Vendor $vendor): array => VendorListData::fromModel($vendor)->toArray(),
            ),
        );

        return $paginator->withQueryString();
    }
}
