<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\Dealership;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DealershipPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, Dealership $dealership): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }
}
