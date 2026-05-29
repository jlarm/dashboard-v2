<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use Closure;
use Illuminate\Database\Eloquent\Collection;

class ReconcileTenantCourses
{
    /**
     * Reconcile per-tenant course copies against the central course_tenant assignments.
     *
     * - Tenants that fall out of scope have their course copy soft-deleted.
     * - Tenants that come back into scope have their soft-deleted copy restored.
     *
     * @param  (Closure(string $message): void)|null  $log  Optional logger for output.
     * @return array{tenants_checked:int, soft_deleted:int, restored:int}
     */
    public function handle(bool $apply = false, ?Closure $log = null): array
    {
        $assignmentsBySlug = Course::query()
            ->with('tenants:id')
            ->get()
            ->mapWithKeys(fn (Course $course): array => [
                $course->slug => $course->tenants->pluck('id')->all(),
            ])
            ->all();

        $stats = [
            'tenants_checked' => 0,
            'soft_deleted' => 0,
            'restored' => 0,
        ];

        Dealership::query()->chunkById(50, function (Collection $tenants) use ($assignmentsBySlug, $apply, $log, &$stats): void {
            foreach ($tenants as $tenant) {
                /** @var Dealership $tenant */
                $stats['tenants_checked']++;
                tenancy()->initialize($tenant);
                $this->reconcileTenant($tenant, $assignmentsBySlug, $apply, $log, $stats);
                tenancy()->end();
            }
        });

        return $stats;
    }

    /**
     * @param  array<string, array<int, string>>  $assignmentsBySlug
     * @param  (Closure(string $message): void)|null  $log
     * @param  array{tenants_checked:int, soft_deleted:int, restored:int}  $stats
     */
    private function reconcileTenant(
        Dealership $tenant,
        array $assignmentsBySlug,
        bool $apply,
        ?Closure $log,
        array &$stats,
    ): void {
        foreach ($assignmentsBySlug as $slug => $assignedTenantIds) {
            $tenantCourse = TenantCourse::withTrashed()->where('slug', $slug)->first();

            if ($tenantCourse === null) {
                continue;
            }

            $isAssigned = $assignedTenantIds === [] || in_array($tenant->id, $assignedTenantIds, true);

            if (! $isAssigned && ! $tenantCourse->trashed()) {
                $stats['soft_deleted']++;
                $log?->__invoke("[{$tenant->name}] soft-delete '{$slug}'");

                if ($apply) {
                    $tenantCourse->delete();
                }
            } elseif ($isAssigned && $tenantCourse->trashed()) {
                $stats['restored']++;
                $log?->__invoke("[{$tenant->name}] restore '{$slug}'");

                if ($apply) {
                    $tenantCourse->restore();
                }
            }
        }
    }
}
