<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\Course;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Spatie\Permission\Models\Role;

class GetInviteEmployeeOptions
{
    private const EXCLUDED_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    /**
     * @return array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{name: string}>,
     *     courses: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>
     * }
     */
    public function handle(User $viewer): array
    {
        return [
            'departments' => $this->departments(),
            'roles' => $this->roles(),
            'courses' => $this->courses(),
            'stores' => $this->stores($viewer),
        ];
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function departments(): array
    {
        return Department::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(static fn (Department $department): array => [
                'id' => (int) $department->id,
                'name' => (string) $department->name,
            ])
            ->all();
    }

    /**
     * @return list<array{name: string}>
     */
    private function roles(): array
    {
        return Role::query()
            ->whereNotIn('name', self::EXCLUDED_ROLES)
            ->orderBy('name')
            ->get(['name'])
            ->map(static fn (Role $role): array => ['name' => (string) $role->name])
            ->all();
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function courses(): array
    {
        return Course::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(static fn (Course $course): array => [
                'id' => (int) $course->id,
                'name' => (string) $course->name,
            ])
            ->all();
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function stores(User $viewer): array
    {
        return $this->storesQuery($viewer)
            ->map(static fn (Store $store): array => [
                'id' => (int) $store->id,
                'name' => (string) $store->name,
            ])
            ->all();
    }

    /**
     * @return EloquentCollection<int, Store>
     */
    private function storesQuery(User $viewer): EloquentCollection
    {
        if ($viewer->hasAnyRole(['super-admin', 'Consultant'])) {
            return Store::query()->orderBy('name')->get(['id', 'name']);
        }

        /** @var EloquentCollection<int, Store> $stores */
        $stores = $viewer->stores()->orderBy('stores.name')->get(['stores.id', 'stores.name']);

        return $stores;
    }
}
