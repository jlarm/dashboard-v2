<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Services\UserCourseService;

trait EmployeeCourses
{
    protected $user;
    protected $courses;

    public function loadCoursesForCurrentUser(): void
    {
        $this->loadCurrentUser();

        $service = resolve(UserCourseService::class);
        $courseIds = $service->getCourseIds($this->user);

        $this->courses = Course::query()
            ->whereIn('id', $courseIds)
            ->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest()])
            ->orderBy('name')
            ->get();
    }

    protected function loadCurrentUser(): void
    {
        $this->user = auth()->user();
    }
}
