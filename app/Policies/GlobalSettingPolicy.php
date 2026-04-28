<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 */
class GlobalSettingPolicy
{
    public function manageReports(User $user): bool
    {
        return $user->hasAnyRole(Role::values(Role::automatedReportRoles()));
    }

    public function manage(User $user): bool
    {
        return $user->hasRole(Role::Consultant->value);
    }
}
