<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\CourseResults;
use Illuminate\Cache\RedisStore;
use Illuminate\Support\Facades\Cache;

class CourseResultsObserver
{
    /**
     * Handle the CourseResults "created" event.
     */
    public function created(CourseResults $courseResults): void
    {
        $this->clearUserCompletionCache($courseResults);
    }

    /**
     * Handle the CourseResults "updated" event.
     */
    public function updated(CourseResults $courseResults): void
    {
        $this->clearUserCompletionCache($courseResults);
    }

    /**
     * Handle the CourseResults "deleted" event.
     */
    public function deleted(CourseResults $courseResults): void
    {
        $this->clearUserCompletionCache($courseResults);
    }

    /**
     * Handle the CourseResults "restored" event.
     */
    public function restored(CourseResults $courseResults): void
    {
        $this->clearUserCompletionCache($courseResults);
    }

    /**
     * Handle the CourseResults "force deleted" event.
     */
    public function forceDeleted(CourseResults $courseResults): void
    {
        $this->clearUserCompletionCache($courseResults);
    }

    /**
     * Clear completion stat cache for affected user.
     */
    private function clearUserCompletionCache(CourseResults $courseResults): void
    {
        // Clear all completion stat caches that might be affected by this user's results
        $userId = $courseResults->user_id;

        // For Redis cache, we can use pattern-based deletion
        if (config('cache.default') === 'redis') {
            $this->clearRedisPatternCache([
                "completed_courses_stat_{$userId}_*",
                "department_completion_stats_{$userId}_*",
            ]);
        } else {
            // For non-Redis cache, clear specific known keys
            // This is less efficient but works with file/array cache
            $this->clearSpecificCaches($userId);
        }

        // Also clear the user's course cache
        if ($courseResults->user) {
            $courseResults->user->clearCourseCache();
        }
    }

    /**
     * Clear Redis cache keys matching patterns.
     */
    private function clearRedisPatternCache(array $patterns): void
    {
        if (! Cache::getStore() instanceof RedisStore) {
            return;
        }

        foreach ($patterns as $pattern) {
            $keys = Cache::getStore()->connection()->keys($pattern);
            if (! empty($keys)) {
                foreach ($keys as $key) {
                    // Remove the Redis prefix if it exists
                    $key = str_replace(config('database.redis.options.prefix', ''), '', $key);
                    Cache::forget($key);
                }
            }
        }
    }

    /**
     * Clear specific cache keys for non-Redis cache drivers.
     */
    private function clearSpecificCaches(int $userId): void
    {
        $storeIds = ['all'];
        $roles = ['admin', 'user'];

        // Clear old individual stat caches
        foreach ($storeIds as $storeId) {
            foreach (range(1, 7) as $department) {
                foreach ($roles as $role) {
                    Cache::forget("completed_courses_stat_{$userId}_{$storeId}_{$department}_{$role}");
                    Cache::forget("completed_courses_stat_{$userId}_{$storeId}_all_{$role}");
                }
            }
        }

        // Clear new combined stat cache
        foreach ($storeIds as $storeId) {
            foreach ($roles as $role) {
                Cache::forget("department_completion_stats_{$userId}_{$storeId}_{$role}");
            }
        }
    }
}
