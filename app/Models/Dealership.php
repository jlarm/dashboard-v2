<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Models\TenantPivot;

class Dealership extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dealership_roles', 'tenant_id', 'global_role_id', 'id', 'global_id')
            ->using(TenantPivot::class);
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'user_id',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
