<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Log;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Index access is gated by the role middleware on the route group.
 * This request only validates query-string filters.
 */
class IndexActivityLogsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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

    public function search(): string
    {
        return mb_trim((string) ($this->validated('search') ?? ''));
    }

    public function page(): int
    {
        $page = $this->validated('page');

        return $page === null ? 1 : (int) $page;
    }
}
