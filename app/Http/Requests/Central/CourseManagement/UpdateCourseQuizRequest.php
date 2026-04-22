<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\CourseManagement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseQuizRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'questions' => ['present', 'array'],
            'questions.*.question' => ['nullable', 'string'],
            'questions.*.answers' => ['nullable', 'array'],
            'questions.*.correctAnswer' => ['nullable', 'string'],
        ];
    }
}
