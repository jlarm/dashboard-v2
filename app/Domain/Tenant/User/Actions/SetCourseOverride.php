<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class SetCourseOverride
{
    public function handle(User $actor, User $target, Course $course, string $state): void
    {
        DB::transaction(function () use ($actor, $target, $course, $state): void {
            $target->courses()->detach($course->id);

            if ($state === 'add' || $state === 'exclude') {
                $target->courses()->attach($course->id, [
                    'type' => $state,
                    'assigned_by' => $actor->id,
                ]);
            }
        });

        $target->clearCourseCache();
        $this->forgetDepartmentStatsCache();
    }

    private function forgetDepartmentStatsCache(): void
    {
        // Stats purging is best-effort — stale entries re-warm on next read (5min TTL),
        // so never let a cache error bubble out and break the main write.
        try {
            $tenantId = tenant('id') ?? 'no-tenant';

            $storeIds = Store::query()->pluck('id')->all();

            foreach ($storeIds as $storeId) {
                Cache::forget("department_completion_stats_{$storeId}_{$tenantId}");
            }

            Cache::forget("department_completion_stats_all_{$tenantId}_admin");
        } catch (Throwable $e) {
            report($e);
        }
    }
}
