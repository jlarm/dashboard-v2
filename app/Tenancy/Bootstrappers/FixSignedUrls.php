<?php

namespace App\Tenancy\Bootstrappers;

use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;
use URL;

class FixSignedUrls implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant)
    {
        URL::formatHostUsing(fn () => 'https://'.$tenant->domains->first()->domain);
    }

    public function revert()
    {
        URL::formatHostUsing(fn () => config('app.url'));
    }
}
