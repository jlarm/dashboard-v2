<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\Central\UserInvite;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 * Each method denies by default; add role-specific rules here when introducing
 * non-super-admin actors.
 */
class InvitePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function delete(User $user, UserInvite $invite): bool
    {
        return false;
    }
}
