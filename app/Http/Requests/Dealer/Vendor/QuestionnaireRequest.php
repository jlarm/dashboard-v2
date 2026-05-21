<?php

declare(strict_types=1);

namespace App\Http\Requests\Dealer\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'store_id' => ['nullable', 'string', 'max:255'],
            'q1a' => ['required', 'string', 'max:255'],
            'q1c' => ['nullable', 'string', 'max:255'],
            'q2a' => ['required', 'string', 'max:255'],
            'q2c' => ['nullable', 'string', 'max:255'],
            'q3a' => ['required', 'string', 'max:255'],
            'q3c' => ['nullable', 'string', 'max:255'],
            'q4a' => ['required', 'string', 'max:255'],
            'q4c' => ['nullable', 'string', 'max:255'],
            'q5a' => ['required', 'string', 'max:255'],
            'q5c' => ['nullable', 'string', 'max:255'],
            'q6a' => ['required', 'string', 'max:255'],
            'q6c' => ['nullable', 'string', 'max:255'],
            'q7a' => ['required', 'string', 'max:255'],
            'q7c' => ['nullable', 'string', 'max:255'],
            'q8a' => ['required', 'string', 'max:255'],
            'q8c' => ['nullable', 'string', 'max:255'],
            'q9a' => ['required', 'string', 'max:255'],
            'q9c' => ['nullable', 'string', 'max:255'],
            'q10a' => ['required', 'string', 'max:255'],
            'q10c' => ['nullable', 'string', 'max:255'],
            'q11a' => ['required', 'string', 'max:255'],
            'q11c' => ['nullable', 'string', 'max:255'],
            'q12a' => ['required', 'string', 'max:255'],
            'q12c' => ['nullable', 'string', 'max:255'],
            'q13a' => ['required', 'string', 'max:255'],
            'q13c' => ['nullable', 'string', 'max:255'],
            'q14a' => ['required', 'string', 'max:255'],
            'q14c' => ['nullable', 'string', 'max:255'],
            'q15a' => ['required', 'string', 'max:255'],
            'q15c' => ['nullable', 'string', 'max:255'],
            'q16a' => ['required', 'string', 'max:255'],
            'q16c' => ['nullable', 'string', 'max:255'],
            'q17a' => ['required', 'string', 'max:255'],
            'q17c' => ['nullable', 'string', 'max:255'],
            'q18a' => ['required', 'string', 'max:255'],
            'q18c' => ['nullable', 'string', 'max:255'],
            'q19a' => ['required', 'string', 'max:255'],
            'q19c' => ['nullable', 'string', 'max:255'],
            'q20a' => ['required', 'string', 'max:255'],
            'q20c' => ['nullable', 'string', 'max:255'],
            'q21a' => ['required', 'string', 'max:255'],
            'q21c' => ['nullable', 'string', 'max:255'],
            'q22a' => ['required', 'string', 'max:255'],
            'q22c' => ['nullable', 'string', 'max:255'],
            'signature' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
