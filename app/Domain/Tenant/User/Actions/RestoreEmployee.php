<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class RestoreEmployee
{
    public function __construct(private readonly PermissionRegistrar $permissionRegistrar) {}

    public function handle(User $user): User
    {
        $user->restore();

        $this->permissionRegistrar->forgetCachedPermissions();

        return $user->refresh();
    }
}
