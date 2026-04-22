<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Store\Actions;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class SwitchCurrentStore
{
    public function handle(User $user, ?int $storeId): void
    {
        if ($storeId === null) {
            $user->forceFill(['current_store_id' => null])->save();

            return;
        }

        throw_unless($this->canAccess($user, $storeId), AuthorizationException::class, 'You do not have access to this location.');

        $user->forceFill(['current_store_id' => $storeId])->save();
    }

    private function canAccess(User $user, int $storeId): bool
    {
        if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()->whereKey($storeId)->exists();
        }

        return $user->stores()->whereKey($storeId)->exists();
    }
}
