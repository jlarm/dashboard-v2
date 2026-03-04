<?php

declare(strict_types=1);

namespace App\Http\Requests\Dealership;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:tenants', 'regex:/^[a-zA-Z0-9 ]+$/'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
