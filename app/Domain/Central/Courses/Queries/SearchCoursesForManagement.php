<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Queries;

use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchCoursesForManagement
{
    public function handle(?string $search): LengthAwarePaginator
    {
        return Course::query()
            ->when($search, fn (Builder $query, string $value) => $query->where('name', 'like', "%{$value}%"))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();
    }
}
