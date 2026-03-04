<?php

declare(strict_types=1);

namespace App\Listeners;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Events\TenantDeleted;
use Stancl\Tenancy\Jobs\DeleteDatabase;

class DeleteTenantDatabaseOnForceDelete
{
    public function handle(TenantDeleted $event): void
    {
        if (! $event->tenant instanceof TenantWithDatabase) {
            return;
        }

        if (method_exists($event->tenant, 'isForceDeleting') && ! $event->tenant->isForceDeleting()) {
            return;
        }

        app()->call([new DeleteDatabase($event->tenant), 'handle']);
    }
}
