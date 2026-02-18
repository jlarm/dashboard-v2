<?php

declare(strict_types=1);

namespace App\Listeners;

use Stancl\Tenancy\Events\TenantDeleted;
use Stancl\Tenancy\Jobs\DeleteDatabase;

class DeleteTenantDatabaseOnForceDelete
{
    public function handle(TenantDeleted $event): void
    {
        if (! $event->tenant->isForceDeleting()) {
            return;
        }

        app()->call([new DeleteDatabase($event->tenant), 'handle']);
    }
}
