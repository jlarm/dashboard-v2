<?php

declare(strict_types=1);

namespace App\Domain\Tenant\FitTests\Queries;

use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GetFitTestEmployees
{
    /**
     * Employees eligible to be assigned a fit test, scoped to the store when
     * the tenant runs multiple stores. Super-admins and consultants are excluded.
     *
     * @return array<int, array{id: int, name: string}>
     */
    public function handle(Store $store): array
    {
        return $this->baseQuery($store)
            ->whereDoesntHave('roles', static function (Builder $query): void {
                $query->whereIn('name', ['super-admin', 'Consultant']);
            })
            ->orderBy('users.name')
            ->get(['users.id', 'users.name'])
            ->map(static fn (User $user): array => [
                'id' => (int) $user->id,
                'name' => (string) $user->name,
            ])
            ->all();
    }

    /**
     * @return Builder<User>|BelongsToMany<User, Store>
     */
    private function baseQuery(Store $store): Builder|BelongsToMany
    {
        $multipleStoresExist = app()->bound('multipleStoresExist') && resolve('multipleStoresExist');

        return $multipleStoresExist ? $store->users() : User::query();
    }
}
