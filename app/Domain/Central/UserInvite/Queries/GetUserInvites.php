<?php

declare(strict_types=1);

namespace App\Domain\Central\UserInvite\Queries;

use App\Models\Central\UserInvite;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUserInvites
{
    /**
     * @return LengthAwarePaginator<int, UserInvite>
     */
    public function handle(): LengthAwarePaginator
    {
        return UserInvite::query()
            ->open()
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }
}
