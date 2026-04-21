<?php

declare(strict_types=1);

namespace App\Policies\Central;

use App\Models\User;
use App\Models\ViolationStatement;
use Illuminate\Auth\Access\HandlesAuthorization;

class ViolationStatementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function view(User $user, ViolationStatement $violationStatement): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, ?ViolationStatement $violationStatement = null): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, ?ViolationStatement $violationStatement = null): bool
    {
        return $user->hasRole('super-admin');
    }
}
