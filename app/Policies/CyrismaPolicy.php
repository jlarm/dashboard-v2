<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Dealer\Cyrisma;
use App\Models\User;

class CyrismaPolicy
{
    private const array SETTINGS_ROLES = [
        'super-admin',
        'Consultant',
    ];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(self::SETTINGS_ROLES);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(self::SETTINGS_ROLES);
    }

    public function update(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(self::SETTINGS_ROLES);
    }

    public function delete(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(self::SETTINGS_ROLES);
    }
}
