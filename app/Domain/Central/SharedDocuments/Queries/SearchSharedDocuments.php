<?php

declare(strict_types=1);

namespace App\Domain\Central\SharedDocuments\Queries;

use App\Models\SharedDocument;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchSharedDocuments
{
    /**
     * @return LengthAwarePaginator<int, SharedDocument>
     */
    public function handle(?string $search): LengthAwarePaginator
    {
        return SharedDocument::query()
            ->when($search, fn (Builder $query, string $value) => $query->where('title', 'like', "%{$value}%"))
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();
    }
}
