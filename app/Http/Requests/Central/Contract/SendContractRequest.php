<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Contract;

use Illuminate\Foundation\Http\FormRequest;

class SendContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('sendForReview', $this->route('contract')) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'emails' => ['required', 'array', 'min:1'],
            'emails.*' => ['required', 'email', 'max:255', 'distinct'],
        ];
    }
}
