<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 * Each method denies by default; add role-specific rules here when introducing
 * non-super-admin actors.
 */
class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, User $model): bool
    {
        return false;
    }

    public function viewDeleted(User $user): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, User $model): bool
    {
        return false;
    }

    public function delete(User $user, User $model): bool
    {
        return false;
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
