<?php

namespace App\Policies;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;

class DealJacketGroupPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function update(User $user, DealJacketGroup $dealJacketGroup): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function delete(User $user, DealJacketGroup $dealJacketGroup): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }
}
