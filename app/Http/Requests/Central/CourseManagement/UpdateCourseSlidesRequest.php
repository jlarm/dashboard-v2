<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\CourseManagement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseSlidesRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'video_id' => ['nullable', 'string', 'max:255'],
            'slides' => ['required', 'array', 'min:1'],
            'slides.*.title' => ['nullable', 'string', 'max:255'],
            'slides.*.description' => ['nullable', 'string'],
        ];
    }
}
