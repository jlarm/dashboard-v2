<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Isp\Queries;

use App\Domain\Tenant\Manuals\Isp\Data\IspManualListItemData;
use App\Models\Dealer\Manual\Isp;
use Illuminate\Support\Collection as SupportCollection;

class ListIspManuals
{
    /**
     * @param  SupportCollection<int, int>  $storeIds
     * @return SupportCollection<int, IspManualListItemData>
     */
    public function handle(SupportCollection $storeIds): SupportCollection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        return Isp::query()
            ->with(['user:id,name', 'store:id,name'])
            ->whereIn('store_id', $storeIds)
            ->latest()
            ->get()
            ->map(fn (Isp $manual): IspManualListItemData => new IspManualListItemData(
                id: (int) $manual->getKey(),
                signedAt: $manual->created_at?->format('M j, Y') ?? '',
                signedAtIso: $manual->created_at?->toIso8601String() ?? '',
                signedByName: (string) ($manual->user->name ?? ''),
                storeName: (string) ($manual->store->name ?? ''),
                downloadUrl: $this->resolveDownloadUrl($manual),
            ))
            ->values();
    }

    private function resolveDownloadUrl(Isp $manual): ?string
    {
        if ($manual->pdf_path === null || $manual->pdf_path === '') {
            return null;
        }

        return route('dealer.manual.isp.download', $manual);
    }
}
