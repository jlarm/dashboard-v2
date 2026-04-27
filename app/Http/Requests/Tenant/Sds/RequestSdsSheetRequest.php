<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Sds;

use Illuminate\Foundation\Http\FormRequest;

class RequestSdsSheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
        ];
    }
}
