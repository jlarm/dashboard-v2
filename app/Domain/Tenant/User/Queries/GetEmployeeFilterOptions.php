<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Enums\Role as RoleEnum;
use App\Models\Department;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class GetEmployeeFilterOptions
{
    /**
     * @return array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{id: int, name: string}>
     * }
     */
    public function handle(): array
    {
        return [
            'departments' => $this->mapOptions($this->departments()),
            'roles' => $this->mapOptions($this->roles()),
        ];
    }

    /**
     * @return Collection<int, Department>
     */
    private function departments(): Collection
    {
        return Department::query()
            ->whereHas('users')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @return Collection<int, Role>
     */
    private function roles(): Collection
    {
        return Role::query()
            ->whereNotIn('name', [RoleEnum::SuperAdmin->value, RoleEnum::Consultant->value])
            ->whereHas('users')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * @template TModel of Department|Role
     *
     * @param  Collection<int, TModel>  $models
     * @return list<array{id: int, name: string}>
     */
    private function mapOptions(Collection $models): array
    {
        return array_values(
            $models
                ->map(static fn (Department|Role $model): array => [
                    'id' => (int) $model->id,
                    'name' => (string) $model->name,
                ])
                ->all(),
        );
    }
}
