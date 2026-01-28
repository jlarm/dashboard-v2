<?php

declare(strict_types=1);

namespace App\Jobs;

use Stancl\Tenancy\Contracts\Tenant;

class CreateFrameworkDirectoriesForTenantJob
{
    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(): void
    {
        $this->tenant->run(function ($tenant) {
            $storage_path = storage_path();
            $cachePath = "{$storage_path}/framework/cache";

            if (! is_dir($cachePath)) {
                mkdir($cachePath, 0777, true);
            }
        });
    }
}
