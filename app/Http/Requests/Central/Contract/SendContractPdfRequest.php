<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\Contract;

use Illuminate\Foundation\Http\FormRequest;

class SendContractPdfRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('sendPdf', $this->route('contract')) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
        ];
    }
}
