<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\ViolationAuditListItemData;
use App\Enums\ViolationAuditType;
use Illuminate\Support\Collection;

class ListViolationAudits
{
    /**
     * @param  Collection<int, int>  $storeIds
     * @return Collection<int, ViolationAuditListItemData>
     */
    public function handle(ViolationAuditType $type, Collection $storeIds): Collection
    {
        if ($storeIds->isEmpty()) {
            return collect();
        }

        $modelClass = $type->modelClass();

        return $modelClass::query()
            ->whereIn('store_id', $storeIds->all())
            ->with(['store:id,name'])
            ->withCount([
                'violations as violation_count',
                'violations as remediation_count' => fn ($q) => $q->whereHas('remediation', fn ($q) => $q->where('completed', true)),
                'auditComments as audit_comments_count',
            ])
            ->latest('date')
            ->get()
            ->map(fn ($audit): ViolationAuditListItemData => ViolationAuditListItemData::fromModel($audit))
            ->values();
    }
}
