<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Queries;

use App\Models\User;

class ListManagers
{
    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function handle(): array
    {
        return User::query()
            ->role('manager')
            ->where('department_id', 6)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(static fn (User $user): array => [
                'id' => (int) $user->id,
                'name' => (string) $user->name,
            ])
            ->all();
    }
}
