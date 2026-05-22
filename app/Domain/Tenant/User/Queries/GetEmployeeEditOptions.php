<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Enums\AuditTypes;
use App\Enums\Role as RoleEnum;
use App\Models\Dealer\Store;
use App\Models\Department;
use App\Models\Role;

class GetEmployeeEditOptions
{
    /**
     * @return array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>|null,
     *     audit_types: list<array{value: string, label: string}>
     * }
     */
    public function handle(): array
    {
        return [
            'departments' => $this->departments(),
            'roles' => $this->roles(),
            'stores' => $this->stores(),
            'audit_types' => $this->auditTypes(),
        ];
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function departments(): array
    {
        return array_values(
            Department::query()
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(static fn (Department $department): array => [
                    'id' => (int) $department->id,
                    'name' => (string) $department->name,
                ])
                ->all(),
        );
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    private function roles(): array
    {
        return array_values(
            Role::query()
                ->whereNotIn('name', [
                    RoleEnum::SuperAdmin->value,
                    RoleEnum::Consultant->value,
                    RoleEnum::QualifiedIndividual->value,
                ])
                ->orderBy('name')
                ->get(['id', 'name'])
                ->map(static fn (Role $role): array => [
                    'id' => (int) $role->id,
                    'name' => (string) $role->name,
                ])
                ->all(),
        );
    }

    /**
     * @return list<array{id: int, name: string}>|null
     */
    private function stores(): ?array
    {
        $stores = Store::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        if ($stores->count() <= 1) {
            return null;
        }

        return array_values(
            $stores
                ->map(static fn (Store $store): array => [
                    'id' => (int) $store->id,
                    'name' => (string) $store->name,
                ])
                ->all(),
        );
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    private function auditTypes(): array
    {
        return array_map(
            static fn (AuditTypes $type): array => ['value' => $type->value, 'label' => $type->label()],
            AuditTypes::cases(),
        );
    }
}
