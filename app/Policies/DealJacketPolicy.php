<?php

namespace App\Policies;

use App\Models\Dealer\Audit\DealJacket;
use App\Models\User;

class DealJacketPolicy
{
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function update(User $user, DealJacket $dealJacket): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function delete(User $user, DealJacket $dealJacket): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }
}
