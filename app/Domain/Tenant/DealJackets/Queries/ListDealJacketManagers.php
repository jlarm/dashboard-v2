<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Queries;

use App\Models\User;

class ListDealJacketManagers
{
    /**
     * Finance department (department_id = 6) managers attached to the given store.
     *
     * @return array<int, array{id: int, name: string}>
     */
    public function handle(int $storeId): array
    {
        return User::query()
            ->where('department_id', 6)
            ->role('Manager')
            ->whereHas('stores', static fn ($query) => $query->where('stores.id', $storeId))
            ->orderBy('name')
            ->get(['users.id', 'users.name'])
            ->map(static fn (User $user): array => [
                'id' => (int) $user->id,
                'name' => (string) $user->name,
            ])
            ->all();
    }
}
