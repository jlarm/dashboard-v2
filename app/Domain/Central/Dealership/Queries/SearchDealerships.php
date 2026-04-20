<?php

declare(strict_types=1);

namespace App\Domain\Central\Dealership\Queries;

use App\Models\Dealership;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SearchDealerships
{
    private const int PER_PAGE = 15;

    public function handle(?string $search, User $user): LengthAwarePaginator
    {
        return $this->baseQuery($user)
            ->when($search, fn (Builder $query, string $value) => $query->where('name', 'like', "%{$value}%"))
            ->with(['users:id,name', 'domains:tenant_id,domain'])
            ->orderBy('name')
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }

    private function baseQuery(User $user): Builder
    {
        return Dealership::query()
            ->when(
                $user->hasRole('Consultant'),
                fn (Builder $query) => $query->whereRelation('users', 'users.id', $user->id),
            );
    }
}
