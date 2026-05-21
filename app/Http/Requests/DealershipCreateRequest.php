<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class DealershipCreateRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'domain' => ['required', 'unique:domains'],
            'url' => ['required', 'url'],
            'locations' => ['required'],
        ];
    }

    #[Override]
    public function prepareForValidation(): void
    {
        $this->merge([
            'domain' => $this->domain.'.'.config('tenancy.central_domains')[0],
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }
}
