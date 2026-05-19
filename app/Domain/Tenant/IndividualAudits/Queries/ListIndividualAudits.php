<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Queries;

use App\Domain\Tenant\IndividualAudits\Data\IndividualAuditListItem;
use App\Models\Dealer\Audit\IndividualAudit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ListIndividualAudits
{
    /**
     * @return Collection<int, IndividualAuditListItem>
     */
    public function handle(int $storeId): Collection
    {
        return IndividualAudit::query()
            ->where('store_id', $storeId)
            ->whereNull('parent_id')
            ->withCount(['children'])
            ->withCount(['children as draft_count' => fn (Builder $query) => $query->where('draft', true)])
            ->latest('audit_date')
            ->get()
            ->map(static fn (IndividualAudit $audit): IndividualAuditListItem => IndividualAuditListItem::fromModel($audit));
    }
}
