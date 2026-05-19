<?php

declare(strict_types=1);

namespace App\Domain\Central\Documents\Queries;

use App\Models\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchDocuments
{
    public function handle(?string $search): LengthAwarePaginator
    {
        return Document::query()
            ->when($search, fn (\Illuminate\Database\Eloquent\Builder $query, string $value) => $query->where('title', 'like', "%{$value}%"))
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();
    }
}
