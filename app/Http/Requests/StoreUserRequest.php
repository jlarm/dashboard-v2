<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'numeric', 'digits:10'],
            'role' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
