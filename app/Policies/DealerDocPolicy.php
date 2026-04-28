<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\DealerDoc;
use App\Models\User;

class DealerDocPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }

    public function delete(User $user, DealerDoc $dealerDoc): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }
}
