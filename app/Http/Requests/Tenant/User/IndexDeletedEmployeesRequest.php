<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\User;

use Illuminate\Foundation\Http\FormRequest;

class IndexDeletedEmployeesRequest extends FormRequest
{
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
        ]) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    /**
     * @return array{search: string}
     */
    public function filters(): array
    {
        return [
            'search' => (string) ($this->validated('search') ?? ''),
        ];
    }

    public function page(): int
    {
        $page = $this->validated('page');

        return $page === null ? 1 : (int) $page;
    }
}
