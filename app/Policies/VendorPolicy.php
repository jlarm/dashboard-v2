<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Role;
use App\Models\Dealer\Vendor;
use App\Models\User;

/**
 * Super-admin access is granted globally via Gate::before in AppServiceProvider.
 *
 * Employees and Porter/Drivers cannot view, create, or manage vendors. Every
 * other role can.
 */
class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->hasManagementRole($user);
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $this->hasManagementRole($user);
    }

    public function create(User $user): bool
    {
        return $this->hasManagementRole($user);
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $this->hasManagementRole($user);
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $this->hasManagementRole($user);
    }

    private function hasManagementRole(User $user): bool
    {
        return ! $user->hasAnyRole([
            Role::Employee->value,
            Role::PorterDriver->value,
        ]);
    }
}
