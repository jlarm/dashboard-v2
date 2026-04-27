<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;

class IndexOpenInvitesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(Role::values(Role::employeeSectionViewers())) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array{search: string, department_id: int|null}
     */
    public function filters(): array
    {
        return [
            'search' => (string) ($this->validated('search') ?? ''),
            'department_id' => $this->validated('department_id') === null
                ? null
                : (int) $this->validated('department_id'),
        ];
    }

    public function page(): int
    {
        $page = $this->validated('page');

        return $page === null ? 1 : (int) $page;
    }
}
