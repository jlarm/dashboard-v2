<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Cms\Queries;

use App\Domain\Tenant\Manuals\Cms\Data\CmsManualListItemData;
use App\Models\CmsManual;
use Illuminate\Support\Collection as SupportCollection;

class ListCmsManuals
{
    /**
     * @param  SupportCollection<int, int>  $storeIds
     * @return SupportCollection<int, CmsManualListItemData>
     */
    public function handle(SupportCollection $storeIds): SupportCollection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        return CmsManual::query()
            ->with(['user:id,name', 'store:id,name'])
            ->whereIn('store_id', $storeIds)
            ->latest()
            ->get()
            ->map(fn (CmsManual $manual): CmsManualListItemData => new CmsManualListItemData(
                id: (int) $manual->getKey(),
                signedAt: $manual->created_at?->format('M j, Y') ?? '',
                signedAtIso: $manual->created_at?->toIso8601String() ?? '',
                signedByName: (string) ($manual->user->name ?? ''),
                storeName: (string) ($manual->store->name ?? ''),
                downloadUrl: $this->resolveDownloadUrl($manual),
            ))
            ->values();
    }

    private function resolveDownloadUrl(CmsManual $manual): ?string
    {
        if ($manual->pdf_path === null || $manual->pdf_path === '') {
            return null;
        }

        return route('dealer.manual.cms.download', $manual);
    }
}
