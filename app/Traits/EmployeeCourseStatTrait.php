<?php

namespace App\Traits;

use App\Models\Dealer\Course;
use App\Models\User;

trait EmployeeCourseStatTrait
{
    protected function getUserById(int $userId): User
    {
        return User::with(['roles', 'stores'])->find($userId);
    }

    protected function users($store, ?string $department): array
    {
        if ($store != null) {
            return $store->users()
                ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
                ->when($department, function ($query, $department) {
                    return $query->where('department_id', $department);
                })
                ->pluck('id')
                ->toArray();
        }

        return User::query()
            ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
            ->when($department, function ($query, $department) {
                return $query->where('department_id', $department);
            })
            ->pluck('id')
            ->toArray();
    }

    protected function roles(int $excludeRoleId, $store, ?string $department): array
    {
        return collect($this->users($store, $department))
            ->flatMap(function ($userId) use ($excludeRoleId) {
                return $this->getUserById($userId)->roles->pluck('id')->reject(fn ($roleId) => $roleId === $excludeRoleId);
            })
            ->unique()
            ->toArray();
    }

    protected function usersWithNoCaliforniaStore($store, ?string $department): array
    {
        return collect($this->users($store, $department))
            ->filter(function ($userId) {
                return ! $this->getUserById($userId)->stores()->where('state', 'California')->exists();
            })
            ->toArray();
    }

    protected function coursesByRole($store, ?string $department): array
    {
        return collect($this->roles(5, $store, $department))
            ->flatMap(function ($roleId) {
                return \DB::table('course_role')
                    ->where('role_id', $roleId)
                    ->pluck('course_id');
            })
            ->toArray();
    }

    protected function courseIdsByDepartment($store, ?string $department): array
    {
        return collect($this->users($store, $department))
            ->flatMap(function ($userId) use ($store, $department) {
                return Course::query()
                    ->whereHas('departments', fn ($query) => $query->where('id', $this->getUserById($userId)->department_id))
                    ->whereIn('id', $this->coursesByRole($store, $department))
                    ->orWhereDoesntHave('departments')
                    ->when(in_array($userId, $this->usersWithNoCaliforniaStore($store, $department)), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-training-in-california'))
                    ->pluck('id');
            })
            ->toArray();
    }

    protected function coursesByDepartment($store, ?string $department): int
    {
        return collect($this->users($store, $department))
            ->sum(function ($userId) use ($store, $department) {
                return Course::query()
                    ->whereHas('departments', fn ($query) => $query->where('id', $this->getUserById($userId)->department_id))
                    ->whereIn('id', $this->coursesByRole($store, $department))
                    ->orWhereDoesntHave('departments')
                    ->when(in_array($userId, $this->usersWithNoCaliforniaStore($store, $department)), fn ($query) => $query->where('slug', '!=', 'sexual-harassment-training-in-california'))
                    ->count();
            });
    }

    protected function totalCompletedCourses($store, ?string $department): int
    {
        return collect($this->users($store, $department))
            ->sum(function ($userId) use ($store, $department) {
                return \DB::table('course_results')
                    ->select('course_id', 'user_id', \DB::raw('MAX(created_at) as latest'))
                    ->where('user_id', $userId)
                    ->where('passed', 1)
                    ->whereIn('course_id', $this->courseIdsByDepartment($store, $department))
                    ->where('created_at', '>=', now()->subYear())
                    ->groupBy('course_id', 'user_id')
                    ->get()
                    ->count();
            });
    }

    public function courseCompletionPercentage($store, ?string $department): int
    {
        $totalCourses = $this->coursesByDepartment($store, $department);
        if ($totalCourses == 0) {
            return 0;
        }

        return round($this->totalCompletedCourses($store, $department) / $this->coursesByDepartment($store, $department) * 100);
    }

    public function percentageByDepartment($store, ?string $department): int
    {
        return $this->courseCompletionPercentage($store, $department);
    }
}
