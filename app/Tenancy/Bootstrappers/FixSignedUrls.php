<?php

declare(strict_types=1);

namespace App\Tenancy\Bootstrappers;

use App\Models\Dealership;
use Illuminate\Support\Facades\URL;
use Stancl\Tenancy\Contracts\TenancyBootstrapper;
use Stancl\Tenancy\Contracts\Tenant;

class FixSignedUrls implements TenancyBootstrapper
{
    public function bootstrap(Tenant $tenant): void
    {
        /** @var Dealership $tenant */
        URL::formatHostUsing(fn (): string => 'https://'.$tenant->domain());
    }

    public function revert(): void
    {
        URL::formatHostUsing(fn () => config('app.url'));
    }
}
