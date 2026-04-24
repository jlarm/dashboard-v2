<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Domain\Tenant\User\Queries\GetInviteEmployeeOptions;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InviteEmployeeRequest extends FormRequest
{
    private const EXCLUDED_ROLES = ['super-admin', 'Admin', 'Consultant', 'Qualified Individual'];

    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole([
            'super-admin',
            'Consultant',
            'Owner',
            'CFO',
            'GM',
            'GSM',
            'Qualified Individual',
            'Manager',
        ]) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $availableStoreIds = $this->availableStoreIds();
        $multipleStores = count($availableStoreIds) > 1;
        $selectedStoreIds = $this->selectedStoreIds();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email', 'unique:invites,email'],
            'department_id' => ['required', 'integer', Rule::exists('departments', 'id')],
            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->whereNotIn('name', self::EXCLUDED_ROLES),
            ],
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
        /** @var array<string|int, string|null>|null $values */
        $values = $this->validated('courses');

        if ($values === null) {
            return [];
        }

        $result = [];
        foreach ($values as $courseId => $date) {
            if ($date === null || $date === '') {
                continue;
            }

            $result[(string) $courseId] = (string) $date;
        }

        return $result;
    }

    /**
     * @return list<int>
     */
    private function availableStoreIds(): array
    {
        /** @var User|null $user */
        $user = $this->user();

        if (! $user instanceof User) {
            return [];
        }

        $options = app(GetInviteEmployeeOptions::class)->handle($user);

        return array_values(array_map(static fn (array $store): int => $store['id'], $options['stores']));
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
