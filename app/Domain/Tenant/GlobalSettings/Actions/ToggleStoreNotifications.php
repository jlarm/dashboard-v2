<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Actions;

use App\Models\Dealer\Store;

class ToggleStoreNotifications
{
    public function handle(Store $store): void
    {
        $store->update([
            'courses_not_taken_notification' => ! $store->courses_not_taken_notification,
        ]);
    }
}
