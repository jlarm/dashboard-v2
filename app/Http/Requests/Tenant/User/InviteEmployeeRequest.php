<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Domain\Tenant\User\Queries\GetInviteEmployeeOptions;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class InviteEmployeeRequest extends FormRequest
{
    /**
     * @var array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{name: string}>,
     *     courses: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>
     * }|null
     */
    private ?array $cachedOptions = null;

    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(Role::values(Role::employeeSectionViewers())) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $options = $this->options();
        $availableStoreIds = array_map(static fn (array $store): int => $store['id'], $options['stores']);
        $availableDepartmentIds = array_map(static fn (array $dept): int => $dept['id'], $options['departments']);
        $availableRoleNames = array_map(static fn (array $role): string => $role['name'], $options['roles']);

        $multipleStores = count($availableStoreIds) > 1;
        $selectedStoreIds = $this->selectedStoreIds();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:invites,email'],
            'department_id' => ['required', 'integer', Rule::in($availableDepartmentIds)],
            'role' => ['required', 'string', Rule::in($availableRoleNames)],
            'qualified_individual' => ['nullable', 'boolean'],
            'store_ids' => [
                Rule::requiredIf($multipleStores),
                'array',
            ],
            'store_ids.*' => ['integer', Rule::in($availableStoreIds)],
            'primary_store_id' => [
                Rule::requiredIf($multipleStores && count($selectedStoreIds) > 1),
                'nullable',
                'integer',
                Rule::in($selectedStoreIds === [] ? $availableStoreIds : $selectedStoreIds),
            ],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'store_ids.required' => 'Select at least one store.',
            'primary_store_id.required' => 'Choose a primary store when assigning multiple stores.',
        ];
    }

    public function name(): string
    {
        return mb_convert_case(mb_trim((string) $this->validated('name')), MB_CASE_TITLE, 'UTF-8');
    }

    public function email(): string
    {
        return mb_strtolower((string) $this->validated('email'));
    }

    public function departmentId(): int
    {
        return (int) $this->validated('department_id');
    }

    public function role(): string
    {
        return (string) $this->validated('role');
    }

    public function qualifiedIndividual(): bool
    {
        if (! $this->canMarkQualifiedIndividual()) {
            return false;
        }

        return $this->boolean('qualified_individual');
    }

    /**
     * @return list<int>
     */
    public function storeIds(): array
    {
        $available = $this->availableStoreIds();

        if (count($available) === 1) {
            return $available;
        }

        return $this->selectedStoreIds();
    }

    public function primaryStoreId(): ?int
    {
        $storeIds = $this->storeIds();

        if (count($storeIds) <= 1) {
            return null;
        }

        $value = $this->validated('primary_store_id');

        return $value === null ? null : (int) $value;
    }

    /**
     * @return array<string, string>
     */
    public function courses(): array
    {
        if (! $this->canAddCompletedCourses()) {
            return [];
        }

        /** @var array<string|int, string|null>|null $values */
        $values = $this->validated('courses');

        if ($values === null) {
            return [];
        }

        $result = [];
        foreach ($values as $courseId => $date) {
            if ($date === null) {
                continue;
            }
            if ($date === '') {
                continue;
            }
            $result[(string) $courseId] = (string) $date;
        }

        return $result;
    }

    private function canMarkQualifiedIndividual(): bool
    {
        /** @var User|null $user */
        $user = $this->user();

        if (! $user instanceof User) {
            return false;
        }

        if (! $user->hasRole(Role::Manager->value)) {
            return true;
        }

        return $user->hasAnyRole(Role::values(Role::employeeAdminRoles()));
    }

    private function canAddCompletedCourses(): bool
    {
        return $this->user()?->hasAnyRole([Role::SuperAdmin->value, Role::Consultant->value]) ?? false;
    }

    /**
     * @return list<int>
     */
    private function availableStoreIds(): array
    {
        return array_values(array_map(
            static fn (array $store): int => $store['id'],
            $this->options()['stores'],
        ));
    }

    /**
     * @return array{
     *     departments: list<array{id: int, name: string}>,
     *     roles: list<array{name: string}>,
     *     courses: list<array{id: int, name: string}>,
     *     stores: list<array{id: int, name: string}>
     * }
     */
    private function options(): array
    {
        /** @var User|null $user */
        $user = $this->user();

        if (! $user instanceof User) {
            return ['departments' => [], 'roles' => [], 'courses' => [], 'stores' => []];
        }

        return $this->cachedOptions ??= resolve(GetInviteEmployeeOptions::class)->handle($user);
    }

    /**
     * @return list<int>
     */
    private function selectedStoreIds(): array
    {
        /** @var array<int, mixed>|null $raw */
        $raw = $this->input('store_ids');

        if (! is_array($raw)) {
            return [];
        }

        return array_values(array_unique(array_map(static fn ($value): int => (int) $value, $raw)));
    }
}
