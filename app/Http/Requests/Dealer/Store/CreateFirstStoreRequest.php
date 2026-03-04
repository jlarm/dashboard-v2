<?php

declare(strict_types=1);

namespace App\Http\Requests\Dealer\Store;

use Illuminate\Foundation\Http\FormRequest;

class CreateFirstStoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:stores,name', 'regex:/^[a-zA-Z0-9 ]+$/'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'website' => ['required', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()?->hasAnyRole(['super-admin', 'Consultant']) ?? false;
    }
}
