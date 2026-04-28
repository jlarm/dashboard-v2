<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Enums\Role as RoleEnum;
use App\Models\Course;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Spatie\Permission\Models\Role;

class GetInviteEmployeeOptions
{
    private const array EXCLUDED_ROLE_VALUES = [
        'super-admin',
        'Admin',
        'Consultant',
        'Qualified Individual',
    ];

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
        $managerOnly = $this->isManagerOnly($viewer);

        return [
            'departments' => $this->departments($viewer, $managerOnly),
            'roles' => $this->roles($managerOnly),
            'courses' => $this->courses(),
            'stores' => $this->stores($viewer, $managerOnly),
        ];
    }

    private function isManagerOnly(User $viewer): bool
    {
        if ($viewer->hasAnyRole(RoleEnum::values(RoleEnum::employeeAdminRoles()))) {
            return false;
        }

        return $viewer->hasRole(RoleEnum::Manager->value);
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function departments(User $viewer, bool $managerOnly): array
    {
        $query = Department::query()->orderBy('name');

        if ($managerOnly && $viewer->department_id !== null) {
            $query->where('id', $viewer->department_id);
        }

        return $query
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
    private function roles(bool $managerOnly): array
    {
        $query = Role::query()->orderBy('name');

        if ($managerOnly) {
            $query->whereIn('name', RoleEnum::values(RoleEnum::managerInvitableRoles()));
        } else {
            $query->whereNotIn('name', self::EXCLUDED_ROLE_VALUES);
        }

        return $query
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
    private function stores(User $viewer, bool $managerOnly): array
    {
        return $this->storesQuery($viewer, $managerOnly)
            ->map(static fn (Store $store): array => [
                'id' => (int) $store->id,
                'name' => (string) $store->name,
            ])
            ->all();
    }

    /**
     * @return EloquentCollection<int, Store>
     */
    private function storesQuery(User $viewer, bool $managerOnly): EloquentCollection
    {
        if ($managerOnly && $viewer->current_store_id !== null) {
            /** @var EloquentCollection<int, Store> $stores */
            $stores = Store::query()
                ->whereKey($viewer->current_store_id)
                ->get(['id', 'name']);

            return $stores;
        }

        if ($viewer->hasAnyRole([RoleEnum::SuperAdmin->value, RoleEnum::Consultant->value])) {
            return Store::query()->orderBy('name')->get(['id', 'name']);
        }

        /** @var EloquentCollection<int, Store> $stores */
        $stores = $viewer->stores()->orderBy('stores.name')->get(['stores.id', 'stores.name']);

        return $stores;
    }
}
