<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Enums\AuditTypes;
use App\Enums\Role as RoleEnum;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $target */
        $target = $this->route('user');

        return $target instanceof User && $this->user()?->can('update', $target);
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    public function messages(): array
    {
        return [
            'store_ids.required' => 'A location is required.',
            'store_ids.array' => 'A location is required.',
            'role_id.exists' => 'Cannot assign privileged roles to an employee.',
        ];
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $multipleStores = Store::query()->count() > 1;
        $auditValues = array_map(static fn (AuditTypes $type): string => $type->value, AuditTypes::cases());

        return [
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')->whereNotIn('name', [
                    RoleEnum::SuperAdmin->value,
                    RoleEnum::Consultant->value,
                ]),
            ],
            'qualified_individual' => ['required', 'boolean'],
            'store_ids' => [Rule::requiredIf($multipleStores), 'array'],
            'store_ids.*' => ['integer', 'exists:stores,id'],
            'audit_types' => ['nullable', 'array'],
            'audit_types.*' => [Rule::in($auditValues)],
        ];
    }

    public function departmentId(): ?int
    {
        $value = $this->validated('department_id');

        return $value === null ? null : (int) $value;
    }

    public function roleId(): int
    {
        return (int) $this->validated('role_id');
    }

    public function qualifiedIndividual(): bool
    {
        return $this->boolean('qualified_individual');
    }

    /**
     * @return list<int>|null Null means "do not change" (single-store tenants).
     */
    public function storeIds(): ?array
    {
        $values = $this->validated('store_ids');

        if ($values === null) {
            return null;
        }

        return array_values(array_map(static fn ($value): int => (int) $value, $values));
    }

    /**
     * @return list<string>
     */
    public function auditTypes(): array
    {
        $values = $this->validated('audit_types') ?? [];

        return array_values(array_map(static fn ($value): string => (string) $value, $values));
    }
}
