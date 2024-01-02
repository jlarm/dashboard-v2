<?php

namespace App\Traits;

use App\Models\Dealer\Course;

trait EmployeeCourses
{
    protected $user;

    protected $courses;

    protected function loadCurrentUser(): void
    {
        $this->user = auth()->user();
    }

    protected function getUserRolesExcluding(int $excludeRoleId): array
    {
        return $this->user->roles()->pluck('id')->reject(function ($roleId) use ($excludeRoleId) {
            return $roleId === $excludeRoleId;
        })->toArray();
    }

    public function getUserHasNoCaliforniaStore(): bool
    {
        return ! $this->user->stores()->where('state', 'California')->exists();
    }

    protected function getCoursesForRoles(array $roles): array
    {
        return \DB::table('course_role')
            ->whereIn('role_id', $roles)
            ->pluck('course_id')
            ->toArray();
    }

    public function loadCoursesForCurrentUser(): void
    {
        $filteredRoles = $this->getUserRolesExcluding(5);
        $courseWithRole = $this->getCoursesForRoles($filteredRoles);
        $californiaStore = $this->getUserHasNoCaliforniaStore();

        $this->courses = Course::query()
            ->whereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->whereIn('id', $courseWithRole)
            ->orWhereDoesntHave('departments')
            ->with([
                'results' => function ($query) {
                    $query->where('user_id', $this->user->id)->latest();
                },
            ])
            ->when($californiaStore, function ($query) {
                $query->where('slug', '!=', 'sexual-harassment-training-in-california');
            })
            ->orderBy('name')
            ->get();
    }
}
