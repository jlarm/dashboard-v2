<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateDealerUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'store' => ['nullable', 'integer'],
            'department' => ['nullable', 'integer'],
            'role' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
