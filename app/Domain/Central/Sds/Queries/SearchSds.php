<?php

declare(strict_types=1);

namespace App\Domain\Central\Sds\Queries;

use App\Models\Sds;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchSds
{
    public function handle(?string $search): LengthAwarePaginator
    {
        return Sds::query()
            ->when($search, function ($query, string $value): void {
                $query->where(function ($query) use ($value): void {
                    $query->where('name', 'like', "%{$value}%")
                        ->orWhere('manufacturer', 'like', "%{$value}%")
                        ->orWhere('file_name', 'like', "%{$value}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
    }
}
