<?php

declare(strict_types=1);

namespace App\Domain\Central\User\Queries;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetDeletedUsers
{
    public function handle(): LengthAwarePaginator
    {
        return User::query()
            ->onlyTrashed()
            ->with('roles:name')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();
    }
}
