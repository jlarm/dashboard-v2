<?php

declare(strict_types=1);

namespace App\Tenancy\Bootstrappers;

use Illuminate\Support\Facades\URL;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class FixSignedUrls implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant): void
    {
        URL::formatHostUsing(fn (): string => 'https://'.$tenant->domains->first()->domain);
    }

    public function revert(): void
    {
        URL::formatHostUsing(fn () => config('app.url'));
    }
}
