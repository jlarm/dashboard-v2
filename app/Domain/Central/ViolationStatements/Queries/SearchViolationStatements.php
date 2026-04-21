<?php

declare(strict_types=1);

namespace App\Domain\Central\ViolationStatements\Queries;

use App\Enums\ViolationStatementCategory;
use App\Models\ViolationStatement;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchViolationStatements
{
    public function handle(?string $search, ?ViolationStatementCategory $category = null): LengthAwarePaginator
    {
        return ViolationStatement::query()
            ->when($search, fn ($query, $value) => $query->where('statement', 'like', "%{$value}%"))
            ->when($category, fn ($query, $value) => $query->whereJsonContains('categories', $value->value))
            ->orderBy('statement')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();
    }
}
