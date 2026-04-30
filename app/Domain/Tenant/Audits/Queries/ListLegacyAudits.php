<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\LegacyAuditListItemData;
use App\Enums\ViolationAuditType;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class ListLegacyAudits
{
    /**
     * @param  Collection<int, int>  $storeIds
     * @return Collection<int, LegacyAuditListItemData>
     */
    public function handle(ViolationAuditType $type, Collection $storeIds): Collection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        $legacyClass = $type->legacyModelClass();

        $query = $legacyClass::query()->whereIn('store_id', $storeIds->all());

        if ($type === ViolationAuditType::Osha) {
            $query->with('violations');
        }

        /** @var EloquentCollection $rows */
        $rows = $query->latest('audit_date')->get();

        return $rows
            ->map(fn ($legacy): LegacyAuditListItemData => LegacyAuditListItemData::fromModel($legacy))
            ->values();
    }

    /**
     * Returns the raw legacy collection for chart-data use; chart builder needs the
     * Eloquent objects so it can read the violations relation when present.
     *
     * @param  Collection<int, int>  $storeIds
     */
    public function raw(ViolationAuditType $type, Collection $storeIds): EloquentCollection
    {
        if ($storeIds->isEmpty()) {
            /** @var EloquentCollection $empty */
            $empty = new EloquentCollection();

            return $empty;
        }

        $legacyClass = $type->legacyModelClass();
        $query = $legacyClass::query()->whereIn('store_id', $storeIds->all());

        if ($type === ViolationAuditType::Osha) {
            $query->with('violations');
        }

        return $query->latest('audit_date')->get();
    }
}
