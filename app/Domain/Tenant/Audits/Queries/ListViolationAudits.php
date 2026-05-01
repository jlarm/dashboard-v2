<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\ViolationAuditListItemData;
use App\Enums\ViolationAuditType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as PaginatorInstance;
use Illuminate\Support\Collection;

class ListViolationAudits
{
    private const int PER_PAGE = 15;

    /**
     * @param  Collection<int, int>  $storeIds
     */
    public function handle(
        ViolationAuditType $type,
        Collection $storeIds,
        bool $includeIncomplete = false,
    ): LengthAwarePaginator {
        if ($storeIds->isEmpty()) {
            return new PaginatorInstance([], 0, self::PER_PAGE);
        }

        $modelClass = $type->modelClass();

        return $modelClass::query()
            ->whereIn('store_id', $storeIds->all())
            ->when(! $includeIncomplete, fn ($query) => $query->whereNotNull('completed_date'))
            ->with(['store:id,name'])
            ->withCount([
                'violations as violation_count',
                'violations as remediation_count' => fn ($q) => $q->whereHas('remediation', fn ($q) => $q->where('completed', true)),
                'auditComments as audit_comments_count',
            ])
            ->latest('date')
            ->paginate(self::PER_PAGE)
            ->through(static fn ($audit): array => ViolationAuditListItemData::fromModel($audit)->toArray())
            ->withQueryString();
    }
}
