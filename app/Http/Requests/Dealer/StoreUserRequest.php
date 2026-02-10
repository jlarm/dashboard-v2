<?php

declare(strict_types=1);

namespace App\Http\Requests\Dealer;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ];
    }
}
