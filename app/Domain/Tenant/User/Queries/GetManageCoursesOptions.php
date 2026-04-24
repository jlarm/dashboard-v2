<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Queries;

use App\Models\CourseUser;
use App\Models\Dealer\Course;
use App\Models\User;
use App\Services\UserCourseService;

class GetManageCoursesOptions
{
    public function __construct(private readonly UserCourseService $courseService) {}

    /**
     * @return list<array{
     *     id: int,
     *     name: string,
     *     required_for_user: bool,
     *     state: 'default'|'add'|'exclude'
     * }>
     */
    public function handle(User $user): array
    {
        $overrides = CourseUser::query()
            ->where('user_id', $user->id)
            ->whereIn('type', ['add', 'exclude'])
            ->pluck('type', 'course_id');

        $assignedCourseIds = array_flip($this->courseService->getCourseIds($user));

        return Course::query()
            ->select(['id', 'name', 'optional'])
            ->orderBy('name')
            ->get()
            ->map(fn (Course $course): array => [
                'id' => (int) $course->id,
                'name' => (string) $course->name,
                'required_for_user' => ! $course->optional && isset($assignedCourseIds[(int) $course->id]),
                'state' => $this->stateFor($overrides, (int) $course->id),
            ])
            ->values()
            ->all();
    }

    /**
     * @param  \Illuminate\Support\Collection<int, string>  $overrides
     * @return 'default'|'add'|'exclude'
     */
    private function stateFor($overrides, int $courseId): string
    {
        $type = $overrides->get($courseId);

        return match ($type) {
            'add' => 'add',
            'exclude' => 'exclude',
            default => 'default',
        };
    }
}
