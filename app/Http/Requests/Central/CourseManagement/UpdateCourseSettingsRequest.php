<?php

declare(strict_types=1);

namespace App\Http\Requests\Central\CourseManagement;

use App\Enums\State;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseSettingsRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $stateLabels = collect(State::cases())
            ->map(fn (State $state): string => $state->label())
            ->all();

        return [
            'department_ids' => ['present', 'array'],
            'department_ids.*' => ['integer', 'exists:departments,id'],
            'role_ids' => ['present', 'array'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
            'states_required' => ['present', 'array'],
            'states_required.*' => ['string', Rule::in($stateLabels)],
            'replaces_course_slugs' => ['present', 'array'],
            'replaces_course_slugs.*' => ['string', 'exists:courses,slug'],
        ];
    }
}
