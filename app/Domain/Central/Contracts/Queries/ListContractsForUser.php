<?php

declare(strict_types=1);

namespace App\Domain\Central\Contracts\Queries;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ListContractsForUser
{
    public function handle(User $user): LengthAwarePaginator
    {
        return Contract::query()
            ->with(['user', 'status'])
            ->unless(
                $user->hasRole('super-admin'),
                fn (Builder $query) => $query->where('user_id', $user->id),
            )
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();
    }
}
