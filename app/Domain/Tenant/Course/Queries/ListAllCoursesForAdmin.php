<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Course\Queries;

use App\Domain\Tenant\Course\Data\UserCourseListItem;
use App\Models\Dealer\Course;
use App\Models\User;
use Illuminate\Support\Collection;

class ListAllCoursesForAdmin
{
    /**
     * @return Collection<int, UserCourseListItem>
     */
    public function handle(User $viewer): Collection
    {
        return Course::query()
            ->withLastResult($viewer->id)
            ->orderBy('name')
            ->get()
            ->map(static fn (Course $course): UserCourseListItem => UserCourseListItem::fromCourse(
                course: $course,
                latest: $course->lastResult,
                isLocked: false,
                moduleIndex: null,
            ));
    }
}
