<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Manuals\RedFlag\Queries;

use App\Domain\Tenant\Manuals\RedFlag\Data\RedFlagManualListItemData;
use App\Models\Dealer\Manual\RedFlag;
use Illuminate\Support\Collection as SupportCollection;

class ListRedFlagManuals
{
    /**
     * @param  SupportCollection<int, int>  $storeIds
     * @return SupportCollection<int, RedFlagManualListItemData>
     */
    public function handle(SupportCollection $storeIds): SupportCollection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        return RedFlag::query()
            ->with(['user:id,name', 'store:id,name'])
            ->whereIn('store_id', $storeIds)
            ->latest()
            ->get()
            ->map(fn (RedFlag $manual): RedFlagManualListItemData => new RedFlagManualListItemData(
                id: (int) $manual->getKey(),
                signedAt: $manual->created_at?->format('M j, Y') ?? '',
                signedAtIso: $manual->created_at?->toIso8601String() ?? '',
                signedByName: (string) ($manual->user->name ?? ''),
                storeName: (string) ($manual->store->name ?? ''),
                downloadUrl: $this->resolveDownloadUrl($manual),
            ))
            ->values();
    }

    private function resolveDownloadUrl(RedFlag $manual): ?string
    {
        if ($manual->pdf_path === null || $manual->pdf_path === '') {
            return null;
        }

        return route('dealer.manual.red-flag.download', $manual);
    }
}
