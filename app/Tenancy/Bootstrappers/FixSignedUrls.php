<?php

namespace App\Tenancy\Bootstrappers;

use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class FixSignedUrls implements TenancyBootstrapper
{
    public function bootstrap(Tenant $dealer)
    {
        \URL::formatHostUsing(function () use ($dealer) {
            return 'https://'.$dealer->domains->first()->domain;
        });
    }

    public function revert()
    {
        \URL::formatHostUsing(function () {
            return config('app.url');
        });
    }
}
