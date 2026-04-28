<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 */
class StorePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }

    public function update(User $user): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }
}
