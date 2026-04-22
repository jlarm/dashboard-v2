<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\CourseManagement;

use Illuminate\Foundation\Http\FormRequest;

class ImportCoursesRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'extensions:json', 'max:5120'],
        ];
    }
}
