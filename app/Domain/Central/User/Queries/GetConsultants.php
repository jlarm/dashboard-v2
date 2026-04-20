<?php

declare(strict_types=1);

namespace App\Domain\Central\User\Queries;

use App\Models\User;
use Illuminate\Support\Collection;

class GetConsultants
{
    /**
     * @return Collection<int, array{id: int, name: string}>
     */
    public function handle(int $excludeUserId): Collection
    {
        return User::query()
            ->role('Consultant')
            ->whereNot('id', $excludeUserId)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
            ])
            ->values();
    }
}
