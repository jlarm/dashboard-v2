<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\ViolationStatement;

use App\Enums\ViolationStatementCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreViolationStatementRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'statement' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:1', 'max:10'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['string', Rule::enum(ViolationStatementCategory::class)],
            'keywords' => ['nullable', 'array'],
            'keywords.*' => ['string', 'max:100'],
            'image' => ['nullable', 'image', 'max:4096'],
        ];
    }
}
