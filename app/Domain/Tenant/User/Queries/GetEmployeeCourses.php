<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Database\Query\Builder;

class GetEmployeeCourses
{
    public function __construct(private readonly UserCourseService $courseService) {}

    /**
     * @return list<array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     last_taken_at: string|null,
     *     status: 'never'|'passed'|'failed'|'expired',
     *     status_label: string,
     *     percentage: int|null
     * }>
     */
    public function handle(User $user): array
    {
        $courseIds = $this->courseService->getCourseIds($user);

        if ($courseIds === []) {
            return [];
        }

        $courses = Course::query()
            ->whereIn('id', $courseIds)
            ->select(['id', 'name', 'slug', 'states_required', 'years_expires'])
            ->orderBy('name')
            ->get();

        $latestResults = CourseResults::query()
            ->select(['id', 'user_id', 'course_id', 'passed', 'percentage', 'created_at'])
            ->where('user_id', $user->id)
            ->whereIn('course_id', $courses->pluck('id'))
            ->whereIn('id', function (Builder $query) use ($courses, $user): void {
                $query->selectRaw('MAX(id)')
                    ->from((new CourseResults)->getTable())
                    ->where('user_id', $user->id)
                    ->whereIn('course_id', $courses->pluck('id'))
                    ->groupBy('course_id');
            })
            ->get()
            ->keyBy('course_id');

        $storeState = $this->currentStoreState();

        return array_values(
            $courses
                ->filter(fn (Course $course): bool => $this->isApplicableToStore($course, $storeState))
                ->map(fn (Course $course): array => $this->toRow($course, $latestResults->get($course->id)))
                ->all(),
        );
    }

    private function currentStoreState(): ?string
    {
        $store = app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null;

        if (! $store instanceof Store) {
            $store = Store::query()->first();
        }

        return $store?->state;
    }

    private function isApplicableToStore(Course $course, ?string $storeState): bool
    {
        $required = $course->states_required;

        if (! is_array($required) || $required === []) {
            return true;
        }

        return $storeState !== null && in_array($storeState, $required, true);
    }

    /**
     * @return array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     last_taken_at: string|null,
     *     status: 'never'|'passed'|'failed'|'expired',
     *     status_label: string,
     *     percentage: int|null
     * }
     */
    private function toRow(Course $course, ?CourseResults $latest): array
    {
        if (! $latest instanceof CourseResults) {
            return [
                'id' => (int) $course->id,
                'name' => (string) $course->name,
                'slug' => (string) $course->slug,
                'last_taken_at' => null,
                'status' => 'never',
                'status_label' => 'Never taken',
                'percentage' => null,
            ];
        }

        assert($latest->created_at !== null);

        $yearsExpires = (int) ($course->years_expires ?? 1);
        $expirationDate = $latest->created_at->copy()->addYears($yearsExpires);
        $percentage = (int) $latest->percentage;

        if ((int) $latest->passed !== 1) {
            $status = 'failed';
            $label = "Failed: {$percentage}%";
        } elseif ($expirationDate->isPast()) {
            $status = 'expired';
            $label = 'Retake Required ('.$expirationDate->format('F d, Y').')';
        } else {
            $status = 'passed';
            $label = "Passed: {$percentage}%";
        }

        return [
            'id' => (int) $course->id,
            'name' => (string) $course->name,
            'slug' => (string) $course->slug,
            'last_taken_at' => $latest->created_at->format('F d, Y'),
            'status' => $status,
            'status_label' => $label,
            'percentage' => $percentage,
        ];
    }
}
