<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Store;

use Illuminate\Foundation\Http\FormRequest;

class SwitchStoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'store_id' => ['nullable', 'integer', 'exists:stores,id'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function storeId(): ?int
    {
        $value = $this->validated('store_id');

        return $value === null ? null : (int) $value;
    }
}
