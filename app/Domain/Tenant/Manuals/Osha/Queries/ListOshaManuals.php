<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\Osha\Queries;

use App\Domain\Tenant\Manuals\Osha\Data\OshaManualListItemData;
use App\Models\Dealer\Manual\Osha;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\Storage;

class ListOshaManuals
{
    /**
     * @param  SupportCollection<int, int>  $storeIds
     * @return SupportCollection<int, OshaManualListItemData>
     */
    public function handle(SupportCollection $storeIds): SupportCollection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        return Osha::query()
            ->with(['user:id,name', 'store:id,name'])
            ->whereIn('store_id', $storeIds)
            ->latest()
            ->get()
            ->map(fn (Osha $manual): OshaManualListItemData => new OshaManualListItemData(
                id: (int) $manual->getKey(),
                signedAt: $manual->created_at?->format('M j, Y g:i A') ?? '',
                signedAtIso: $manual->created_at?->toIso8601String() ?? '',
                signedByName: (string) ($manual->user->name ?? ''),
                storeName: (string) ($manual->store->name ?? ''),
                downloadUrl: $this->resolveDownloadUrl($manual),
            ))
            ->values();
    }

    private function resolveDownloadUrl(Osha $manual): ?string
    {
        if ($manual->pdf_path === null || $manual->pdf_path === '') {
            return null;
        }

        return Storage::disk('do-manuals')->url(tenant('id').'/osha/'.$manual->pdf_path);
    }
}
