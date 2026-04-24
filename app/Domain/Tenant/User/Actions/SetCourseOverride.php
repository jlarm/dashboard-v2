<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        // The tenant cache driver may not support every operation (e.g. tagging
        // via stancl/tenancy when the store is file/database). Stats purging is
        // best-effort — stale stats re-warm on their next read, so never let a
        // cache error bubble out and break the main write.
        try {
            $tenantId = tenant('id') ?? 'no-tenant';

            foreach (Store::query()->pluck('id')->all() as $storeId) {
                $this->safeForget("department_completion_stats_{$storeId}_{$tenantId}");
            }

            $this->safeForget("department_completion_stats_all_{$tenantId}_admin");

            User::query()
                ->with('stores:id')
                ->get()
                ->each(function (User $user) use ($tenantId): void {
                    if ($user->hasAnyRole(['super-admin', 'Consultant'])) {
                        return;
                    }

                    $userStoreIds = $user->stores->pluck('id')->sort()->implode('_');

                    $this->safeForget("department_completion_stats_all_{$tenantId}_user_{$userStoreIds}");
                });
        } catch (Exception) {
            // No-op.
        }
    }

    private function safeForget(string $key): void
    {
        try {
            Cache::forget($key);
        } catch (Exception) {
            // No-op.
        }
    }
}
