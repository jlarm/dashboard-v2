<?php

declare(strict_types=1);

namespace App\Tenancy\Bootstrappers;

use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class SpatiePermissionsBootstrapper implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant): void
    {
        config()->set('permission.cache.key', 'spatie.permission.cache.'.$tenant->id);
    }

    public function revert(): void
    {
        config()->set('permission.cache.key', 'spatie.permission.cache');
    }
}
