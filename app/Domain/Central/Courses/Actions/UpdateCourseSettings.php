<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Domain\Central\Courses\Data\CourseSettingsData;
use App\Http\Livewire\Dealer\Employee\DepartmentCompletionStats;
use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class UpdateCourseSettings
{
    public function handle(Course $course, CourseSettingsData $data): Course
    {
        $attributes = [
            'states_required' => $data->states_required === [] ? null : $data->states_required,
            'replaces_course_slugs' => $data->replaces_course_slugs === [] ? null : $data->replaces_course_slugs,
        ];

        $roleNames = Role::query()
            ->whereIn('id', $data->role_ids)
            ->pluck('name')
            ->all();

        tenancy()->central(function () use ($course, $data, $attributes, $roleNames): void {
            $course->update($attributes);
            $course->departments()->sync($data->department_ids);
            $course->roles()->sync($data->role_ids);
            $course->tenants()->sync($data->tenant_ids);

            Dealership::query()->chunkById(50, function (Collection $tenants) use ($course, $data, $attributes, $roleNames): void {
                foreach ($tenants as $tenant) {
                    /** @var Dealership $tenant */
                    tenancy()->initialize($tenant);
                    $this->reconcileTenantCourse((string) $tenant->id, $course, $data, $attributes, $roleNames);
                    DepartmentCompletionStats::flushCacheForCurrentTenant();
                    tenancy()->end();
                }
            });
        });

        return $course->refresh();
    }

    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<int, string>  $roleNames
     */
    private function reconcileTenantCourse(
        string $tenantId,
        Course $course,
        CourseSettingsData $data,
        array $attributes,
        array $roleNames,
    ): void {
        $isAssigned = $data->tenant_ids === [] || in_array($tenantId, $data->tenant_ids, true);
        $tenantCourse = TenantCourse::withTrashed()->where('slug', $course->slug)->first();

        if ($tenantCourse === null) {
            return;
        }

        if (! $isAssigned) {
            if (! $tenantCourse->trashed()) {
                $tenantCourse->delete();
            }

            return;
        }

        if ($tenantCourse->trashed()) {
            $tenantCourse->restore();
        }

        $tenantCourse->update($attributes);
        $tenantCourse->departments()->sync($data->department_ids);

        $tenantRoleIds = Role::query()
            ->whereIn('name', $roleNames)
            ->pluck('id')
            ->all();

        $tenantCourse->roles()->sync($tenantRoleIds);
    }
}
