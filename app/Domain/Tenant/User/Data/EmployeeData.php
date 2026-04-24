<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

use App\Models\User;
use Illuminate\Support\Str;

final readonly class EmployeeData
{
    /**
     * @param  list<array{id: int, name: string}>  $roles
     * @param  list<array{id: int, name: string}>  $stores
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $slug,
        public string $email,
        public ?string $departmentName,
        public array $roles,
        public array $stores,
        public TrainingSummaryData $training,
        public bool $hasQualifiedIndividualRole,
        public bool $canView,
    ) {}

    public static function fromModel(
        User $user,
        TrainingSummaryData $training,
        bool $canView,
    ): self {
        $roles = $user->roles
            ->map(static fn ($role): array => [
                'id' => (int) $role->id,
                'name' => (string) $role->name,
            ])
            ->values()
            ->all();

        $stores = $user->stores
            ->sortBy('name')
            ->map(static fn ($store): array => [
                'id' => (int) $store->id,
                'name' => (string) $store->name,
            ])
            ->values()
            ->all();

        return new self(
            id: (int) $user->id,
            name: Str::headline((string) $user->name),
            slug: (string) $user->slug,
            email: (string) $user->email,
            departmentName: $user->department?->name,
            roles: array_values(array_filter(
                $roles,
                static fn (array $role): bool => $role['name'] !== 'Qualified Individual',
            )),
            stores: $stores,
            training: $training,
            hasQualifiedIndividualRole: collect($roles)->contains(
                static fn (array $role): bool => $role['name'] === 'Qualified Individual',
            ),
            canView: $canView,
        );
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     email: string,
     *     department_name: string|null,
     *     roles: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>,
     *     training: array<string, mixed>,
     *     has_qualified_individual_role: bool,
     *     can_view: bool
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'email' => $this->email,
            'department_name' => $this->departmentName,
            'roles' => $this->roles,
            'stores' => $this->stores,
            'training' => $this->training->toArray(),
            'has_qualified_individual_role' => $this->hasQualifiedIndividualRole,
            'can_view' => $this->canView,
        ];
    }
}
