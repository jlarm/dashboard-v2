<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContractPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function view(User $user, Contract $contract): bool
    {
        return $user->hasRole('super-admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    public function update(User $user, Contract $contract): bool
    {
        return $user->hasRole('super-admin');
    }

    public function delete(User $user, Contract $contract): bool
    {
        return $user->hasRole('super-admin');
    }

    public function restore(User $user, Contract $contract): bool
    {
    }

    public function forceDelete(User $user, Contract $contract): bool
    {
    }
}
