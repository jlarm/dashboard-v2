<?php

namespace App\Traits;

use App\Models\Dealer\Course;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        return $this->user->roles()->pluck('id')->reject(fn ($roleId) => $roleId === $excludeRoleId)->toArray();
    }

    public function getUserHasNoCaliforniaStore(): bool
    {
        return ! $this->user->stores()->where('state', 'California')->exists();
    }

    protected function getCoursesForRoles(array $roles): array
    {
        return DB::table('course_role')
            ->whereIn('role_id', $roles)
            ->pluck('course_id')
            ->toArray();
    }

    protected function getDepartmentCourses(array $courseWithRole): Collection
    {
        return Course::query()
            ->whereHas('departments', fn ($query) => $query->where('id', $this->user->department_id))
            ->whereIn('id', $courseWithRole)
            ->orWhereDoesntHave('departments')
            ->where('optional', false)
            ->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest()])
            ->when($this->getUserHasNoCaliforniaStore(), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-training-in-california'))
            ->when($this->user->roles()->where('id', 10)->exists(), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-m'))
            ->when($this->user->roles()->where('id', 9)->exists(), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-e'))
            ->orderBy('name')
            ->get();
    }

    protected function getUserCourses(): Collection
    {
        return $this->user->courses()->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest('id')])->get();
    }

    public function loadCoursesForCurrentUser(): void
    {
        $this->loadCurrentUser();
        $filteredRoles = $this->getUserRolesExcluding(5);
        $courseWithRole = $this->getCoursesForRoles($filteredRoles);

        $departmentCourses = $this->getDepartmentCourses($courseWithRole);
        $userCourses = $this->getUserCourses();

        $this->courses = $departmentCourses->merge($userCourses)->unique('id')->sortBy('name');
    }
}
