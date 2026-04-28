<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Vendor;

use App\Models\Dealer\Vendor;
use Illuminate\Foundation\Http\FormRequest;

class IndexVendorsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('viewAny', Vendor::class) ?? false;
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
        return (string) ($this->validated('search') ?? '');
    }

    public function page(): int
    {
        $page = $this->validated('page');

        return $page === null ? 1 : (int) $page;
    }
}
