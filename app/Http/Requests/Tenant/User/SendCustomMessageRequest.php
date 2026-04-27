<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Domain\Tenant\User\Data\EmployeeFiltersData;
use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendCustomMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(Role::values(Role::sendMessageRoles())) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'select_all' => ['nullable', 'boolean'],
            'user_ids' => ['required_without:select_all', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'message_body' => ['required', 'string', 'max:10000'],
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
        ];
    }

    public function selectAll(): bool
    {
        return $this->boolean('select_all');
    }

    /**
     * @return list<int>
     */
    public function userIds(): array
    {
        /** @var list<int|string> $ids */
        $ids = $this->validated('user_ids') ?? [];

        return array_map(static fn ($id): int => (int) $id, $ids);
    }

    public function subjectLine(): string
    {
        return (string) $this->validated('subject');
    }

    public function messageBody(): string
    {
        return (string) $this->validated('message_body');
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

        return array_values(array_map(static fn ($value): int => (int) $value, $values));
    }
}
