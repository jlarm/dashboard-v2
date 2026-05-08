<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Domain;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 * @property string|null $phone
 * @property string|null $tenancy_db_name
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_code
 * @property string|null $fax
 * @property string|null $domain
 * @property string|null $url
 * @property bool|null $locations
 * @property Carbon|null $suspended_at
 */
class Dealership extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, SoftDeletes;

    protected ?string $cachedDomain = null;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'user_id',
            'suspended_at',
        ];
    }

    public function isSuspended(): bool
    {
        return $this->suspended_at !== null;
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class, 'tenant_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'dealership_roles', 'tenant_id', 'global_role_id', 'id', 'global_id')
            ->using(TenantPivot::class);
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user', 'tenant_id', 'user_id');
    }

    public function domain(): ?string
    {
        return $this->resolveDomain();
    }

    protected function getPhoneNumberAttribute(): string
    {
        $cleaned = preg_replace('/[^[:digit:]]/', '', (string) $this->phone);
        preg_match('/(\d{3})(\d{3})(\d{4})/', (string) $cleaned, $matches);

        return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
    }

    protected function getDomainAttribute(): ?string
    {
        return $this->resolveDomain();
    }

    private function resolveDomain(): ?string
    {
        if ($this->cachedDomain !== null) {
            return $this->cachedDomain;
        }

        $first = $this->relationLoaded('domains')
            ? $this->domains->first()
            : $this->domains()->first();

        if ($first instanceof Domain) {
            return $this->cachedDomain = $first->domain;
        }

        return null;
    }
}
