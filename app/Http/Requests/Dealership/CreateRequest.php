<?php

namespace App\Http\Requests\Dealership;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'fax' => ['nullable', 'string', 'max:255'],
            'domain' => ['required', 'string', 'max:255', 'unique:domains'],
            'url' => ['required', 'string', 'max:255', 'url'],
            'locations' => ['nullable', 'boolean'],
            'password' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
