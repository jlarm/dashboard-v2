<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Queries;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchViolationStatements
{
    /**
     * @return LengthAwarePaginator<int, ViolationStatement>
     */
    public function handle(?string $search, ?ViolationStatementCategory $category = null): LengthAwarePaginator
    {
        return ViolationStatement::query()
            ->when($search, fn (Builder $query, string $value) => $query->where('statement', 'like', "%{$value}%"))
            ->when($category, fn (Builder $query, ViolationStatementCategory $value) => $query->whereJsonContains('categories', $value->value))
            ->orderBy('statement')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();
    }
}
