<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\ViolationAuditListItemData;
use App\Enums\ViolationAuditType;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginatorInstance;
use Illuminate\Support\Collection;

class ListViolationAudits
{
    private const int PER_PAGE = 15;

    /**
     * @param  Collection<int, int>  $storeIds
     * @return LengthAwarePaginator<int, array<string, mixed>>
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
            ->unless($includeIncomplete, fn (Builder $query) => $query->whereNotNull('completed_date'))
            ->with(['store:id,name'])
            ->withCount([
                'violations as violation_count',
                'violations as remediation_count' => fn (Builder $q) => $q->whereHas('remediation', fn (Builder $q) => $q->where('completed', true)),
                'auditComments as audit_comments_count',
            ])
            ->latest('date')
            ->paginate(self::PER_PAGE)
            ->through(static fn (ViolationAudit&Model $audit): array => ViolationAuditListItemData::fromModel($audit)->toArray()) // @phpstan-ignore argument.type
            ->withQueryString();
    }
}
