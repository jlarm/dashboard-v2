<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Domain\Tenant\User\Data\EmployeeFiltersData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexEmployeesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'department_ids' => ['nullable', 'array'],
            'department_ids.*' => ['integer', 'exists:departments,id'],
            'role_ids' => ['nullable', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
            'only_incomplete' => ['nullable', 'boolean'],
            'only_expired' => ['nullable', 'boolean'],
            'only_expiring_soon' => ['nullable', 'boolean'],
            'sort_field' => ['nullable', Rule::in(['name', 'department', 'role'])],
            'sort_direction' => ['nullable', Rule::in(['asc', 'desc'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function filters(): EmployeeFiltersData
    {
        return new EmployeeFiltersData(
            search: (string) ($this->validated('search') ?? ''),
            departmentIds: $this->integerList('department_ids'),
            roleIds: $this->integerList('role_ids'),
            onlyIncomplete: $this->boolean('only_incomplete'),
            onlyExpired: $this->boolean('only_expired'),
            onlyExpiringSoon: $this->boolean('only_expiring_soon'),
            sortField: (string) ($this->validated('sort_field') ?? 'name'),
            sortDirection: (string) ($this->validated('sort_direction') ?? 'asc'),
        );
    }

    public function page(): int
    {
        $page = $this->validated('page');

        return $page === null ? 1 : (int) $page;
    }

    /**
     * @return list<int>
     */
    private function integerList(string $key): array
    {
        /** @var list<int|string>|null $values */
        $values = $this->validated($key);

        if ($values === null) {
            return [];
        }

        return array_map(static fn (int|string $value): int => (int) $value, $values);
    }
}
