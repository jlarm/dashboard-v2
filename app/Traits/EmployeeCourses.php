<?php

namespace App\Traits;

use App\Models\Dealer\Course;

trait EmployeeCourses
{
    public function loadCoursesForCurrentUser($user)
    {
        $departmentId = $user->department_id;
        $roleIds = $user->roles()->pluck('id')->toArray();

        // Check if any of the user's stores are in California
        $isInCalifornia = $user->stores->contains(function ($store) {
            return $store->state === 'California';
        });

        // Eager load departments, roles, and results to prevent N+1
        $courses = Course::with(['departments', 'roles', 'results' => function ($query) use ($user) {
            $query->where('user_id', $user->id)->latest('id');
        }])->get();

        $coursesByDepartment = $courses->filter(function ($course) use ($departmentId) {
            return $course->departments->contains('id', $departmentId);
        });

        $coursesByRole = $courses->filter(function ($course) use ($roleIds) {
            return !$course->departments->count() && $course->roles->pluck('id')->intersect($roleIds)->isNotEmpty();
        });

        $coursesByDepartmentNoRoles = $courses->filter(function ($course) use ($departmentId) {
            return $course->departments->contains('id', $departmentId) && !$course->roles->count();
        });

        $coursesNoDepartmentsNoRoles = $courses->filter(function ($course) {
            return !$course->departments->count() && !$course->roles->count();
        });

        $userCourses = $user->courses()->get();

        // Filter courses by department and roles
        $coursesByDepartmentAndRole = $courses->filter(function ($course) use ($departmentId, $roleIds) {
            return $course->departments->contains('id', $departmentId) &&
                   $course->roles->pluck('id')->intersect($roleIds)->isNotEmpty();
        });

        $allCourses = $coursesByDepartmentAndRole
            ->merge($coursesByRole)
            ->merge($coursesByDepartmentNoRoles)
            ->merge($coursesNoDepartmentsNoRoles)
            ->merge($userCourses);

        // Filter out the course with the specific slug if none of the stores are in California
        if (!$isInCalifornia) {
            $allCourses = $allCourses->reject(function ($course) {
                return $course->slug === 'sexual-harassment-training-in-california';
            });
        }

        return $allCourses->sortBy('name'); // Sort the final collection by name
    }

    public function getTotalCoursesAttribute(): int
    {
        return $this->loadCoursesForCurrentUser($this)->count();
    }

    public function getTotalCompletedCoursesAttribute(): int
    {
        return $this->loadCoursesForCurrentUser($this)->filter(function ($course) {
            $latestResult = $this->results()
                ->where('course_id', $course->id)
                ->where('passed', true)
                ->where('created_at', '>=', now()->subYear())
                ->latest()
                ->first();
            
            return $latestResult !== null;
        })->count();
    }

    public function getUserHasNotCompletedCoursesAttribute(): bool
    {
        return $this->total_completed_courses != $this->total_courses;
    }
}
