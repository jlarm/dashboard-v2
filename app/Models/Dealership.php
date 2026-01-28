<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Models\TenantPivot;

class Dealership extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'user_id',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dealership_roles', 'tenant_id', 'global_role_id', 'id', 'global_id')
            ->using(TenantPivot::class);
    }

    public function getPhoneNumberAttribute(): string
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user', 'tenant_id', 'user_id');
    }
}
