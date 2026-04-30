<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Queries;

use App\Domain\Tenant\Audits\Data\ViolationStatementSearchResultData;
use App\Enums\ViolationAuditType;
use App\Models\ViolationStatement;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SearchViolationStatements
{
    /**
     * @return Collection<int, ViolationStatementSearchResultData>
     */
    public function handle(ViolationAuditType $type, string $query): Collection
    {
        if (mb_strlen($query) < 2) {
            return collect();
        }

        $category = $type->violationStatementCategory()->value;

        $all = Cache::remember(
            'violation_statements.'.$category,
            now()->addDay(),
            fn () => tenancy()->central(fn () => ViolationStatement::query()
                ->whereJsonContains('categories', $category)
                ->get())
        );

        return $all
            ->filter(fn (ViolationStatement $statement): bool => mb_stripos($statement->statement, $query) !== false
                || collect($statement->keywords)->contains(fn ($keyword): bool => mb_stripos((string) $keyword, $query) !== false)
            )
            ->map(fn (ViolationStatement $statement): ViolationStatementSearchResultData => ViolationStatementSearchResultData::fromModel($statement))
            ->values();
    }
}
