<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Dealer\Cyrisma;
use App\Models\User;

class CyrismaPolicy
{
    private const VIEW_ROLES = [
        'super-admin',
        'Consultant',
        'Owner',
        'CFO',
        'GM',
        'GSM',
        'Qualified Individual',
        'Manager',
    ];

    private const MUTATION_ROLES = [
        'super-admin',
        'Consultant',
    ];

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(self::VIEW_ROLES);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(self::MUTATION_ROLES);
    }

    public function update(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(self::MUTATION_ROLES);
    }

    public function delete(User $user, Cyrisma $cyrisma): bool
    {
        return $user->hasAnyRole(self::MUTATION_ROLES);
    }
}
