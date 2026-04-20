<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Dealership;

use App\Models\Dealership;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Dealership::class) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:tenants', 'regex:/^[a-zA-Z0-9 \'\-\.\&]+$/'],
            'consultant_ids' => ['nullable', 'array'],
            'consultant_ids.*' => ['integer', 'exists:users,id'],
        ];
    }
}
