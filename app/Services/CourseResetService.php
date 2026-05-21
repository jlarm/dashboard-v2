<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Collection;

class CourseResetService
{
    /**
     * @param  Collection<int, int>|null  $selectedUserIds
     * @return Collection<int, int>
     */
    public function reset(?Store $store = null, ?Collection $selectedUserIds = null): Collection
    {
        $userIds = $this->resolveUserIds($store, $selectedUserIds);

        if ($userIds->isEmpty()) {
            return collect();
        }

        $affectedUserIds = collect();

        CourseResults::query()
            ->whereIn('user_id', $userIds)
            ->chunkById(100, function (\Illuminate\Database\Eloquent\Collection $results) use ($affectedUserIds): void {
                $results->each(function (CourseResults $result) use ($affectedUserIds): void {
                    $affectedUserIds->push((int) $result->user_id);
                    $result->delete();
                });
            });

        $uniqueUserIds = $affectedUserIds
            ->map(static fn (mixed $userId): int => (int) $userId)
            ->unique()
            ->values();

        $this->clearCacheForUsers($uniqueUserIds);

        return $uniqueUserIds;
    }

    /**
     * @param  Collection<int, int>|null  $selectedUserIds
     * @return Collection<int, int>
     */
    private function resolveUserIds(?Store $store = null, ?Collection $selectedUserIds = null): Collection
    {
        $normalizedSelectedUserIds = ($selectedUserIds ?? collect())
            ->map(static fn (mixed $userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();

        if ($store instanceof Store) {
            $storeUserIds = $store->users()
                ->pluck('users.id')
                ->map(static fn (mixed $userId): int => (int) $userId)
                ->filter()
                ->unique()
                ->values();

            if ($normalizedSelectedUserIds->isNotEmpty()) {
                return $storeUserIds
                    ->intersect($normalizedSelectedUserIds)
                    ->values();
            }

            return $storeUserIds;
        }

        if ($normalizedSelectedUserIds->isNotEmpty()) {
            return $normalizedSelectedUserIds;
        }

        return CourseResults::query()
            ->distinct()
            ->pluck('user_id')
            ->map(static fn (mixed $userId): int => (int) $userId)
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * @param  Collection<int, int>  $userIds
     */
    private function clearCacheForUsers(Collection $userIds): void
    {
        if ($userIds->isEmpty()) {
            return;
        }

        User::query()
            ->whereIn('id', $userIds)
            ->chunkById(100, function (\Illuminate\Database\Eloquent\Collection $users): void {
                $users->each(function (User $user): void {
                    $user->clearCourseCache();
                });
            });
    }
}
