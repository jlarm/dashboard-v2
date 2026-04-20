<?php

declare(strict_types=1);

namespace App\Domain\Central\User\Queries;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUsers
{
    public function handle(): LengthAwarePaginator
    {
        return User::query()
            ->withCompletedCoursesCount()
            ->with('roles:name')
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();
    }
}
