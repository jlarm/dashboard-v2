<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant\Settings;

use App\Domain\Tenant\GlobalSettings\Data\ResetCoursesData;
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
            'mode' => [
                'required',
                'string',
                'in:'.ResetCoursesData::MODE_EVERYONE.','.ResetCoursesData::MODE_SELECTED_USERS,
            ],
            'user_ids' => [
                'array',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if ($this->input('mode') === ResetCoursesData::MODE_SELECTED_USERS && (! is_array($value) || $value === [])) {
                        $fail('Select at least one user to reset.');
                    }
                },
            ],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ];
    }

    public function toData(): ResetCoursesData
    {
        /** @var array{mode: string, user_ids?: list<int|string>} $validated */
        $validated = $this->validated();

        $userIds = collect($validated['user_ids'] ?? [])
            ->map(static fn (mixed $userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values()
            ->all();

        return new ResetCoursesData(
            mode: $validated['mode'],
            selectedUserIds: $userIds,
        );
    }
}
