<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Dealer\Cyrisma;
use App\Models\User;

class CyrismaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function update(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }

    public function delete(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(['super-admin', 'Consultant']);
    }
}
