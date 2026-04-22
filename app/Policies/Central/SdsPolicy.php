<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\Sds;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SdsPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, Sds $sds): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, Sds $sds): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, Sds $sds): bool
    {
        return $user->hasRole('super-admin');
    }
}
