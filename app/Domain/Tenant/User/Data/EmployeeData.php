<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Data;

use App\Enums\Role;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

/**
 * @implements Arrayable<string, mixed>
 */
final readonly class EmployeeData implements Arrayable
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
        public ?string $lastLoginAt,
        public ?string $lastLoginAtRelative,
    ) {}

    public static function fromModel(
        User $user,
        TrainingSummaryData $training,
        bool $canView,
    ): self {
        $roles = $user->roles
            ->map(static fn (\Spatie\Permission\Models\Role $role): array => [
                'id' => (int) $role->id,
                'name' => (string) $role->name,
            ])
            ->values()
            ->all();

        $stores = array_values(
            $user->stores
                ->sortBy('name')
                ->map(static fn (Store $store): array => [
                    'id' => (int) $store->id,
                    'name' => (string) $store->name,
                ])
                ->all(),
        );

        return new self(
            id: (int) $user->id,
            name: Str::headline((string) $user->name),
            slug: (string) $user->slug,
            email: Str::lower((string) $user->email),
            departmentName: $user->department?->name,
            roles: array_values(array_filter(
                $roles,
                static fn (array $role): bool => $role['name'] !== Role::QualifiedIndividual->value,
            )),
            stores: $stores,
            training: $training,
            hasQualifiedIndividualRole: collect($roles)->contains(
                static fn (array $role): bool => $role['name'] === Role::QualifiedIndividual->value,
            ),
            canView: $canView,
            lastLoginAt: $user->last_login_at?->format('F d, Y g:i A'),
            lastLoginAtRelative: $user->last_login_at?->diffForHumans(),
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
     *     can_view: bool,
     *     last_login_at: string|null,
     *     last_login_at_relative: string|null
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
            'last_login_at' => $this->lastLoginAt,
            'last_login_at_relative' => $this->lastLoginAtRelative,
        ];
    }
}
