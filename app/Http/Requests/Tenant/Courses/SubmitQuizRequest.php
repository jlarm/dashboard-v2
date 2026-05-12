<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Courses;

use Illuminate\Foundation\Http\FormRequest;

class SubmitQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'array'],
            'question.*' => ['required', 'string'],
        ];
    }

    /**
     * @return array<int, string>
     */
    public function answers(): array
    {
        /** @var array<int, string> $answers */
        $answers = $this->validated()['question'];

        return $answers;
    }
}
