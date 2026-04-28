<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Models\Dealer\CourseResults;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class ResetCoursesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('resetCourses', CourseResults::class) ?? false;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'mode' => ['required', 'string', 'in:everyone,selected-users'],
            'user_ids' => [
                'array',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->input('mode') === 'selected-users' && (! is_array($value) || $value === [])) {
                        $fail('Select at least one user to reset.');
                    }
                },
            ],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ];
    }
}
