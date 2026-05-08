<?php

declare(strict_types=1);

namespace App\Domain\Tenant\StoreSettings\Actions;

use App\Domain\Tenant\GlobalSettings\Data\ResetCoursesData;
use App\Domain\Tenant\StoreSettings\Queries\GetStoreResettableUsers;
use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\CourseResetService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class ResetStoreCourses
{
    public function __construct(
        private readonly CourseResetService $courseResetService,
        private readonly GetStoreResettableUsers $getStoreResettableUsers,
    ) {}

    public function handle(Store $store, ResetCoursesData $data, ?User $causer): void
    {
        $selectedUserIds = collect($data->selectedUserIds);

        $userIdsForReset = $data->isSelectedUsers()
            ? $selectedUserIds
            : $this->getStoreResettableUsers->userIdsForStore($store);

        $affectedUserIds = $this->courseResetService->reset(
            store: $store,
            selectedUserIds: $userIdsForReset,
        );

        // Logging and notifications are bookkeeping after the destructive reset has
        // already committed. Don't let a logging or queue failure surface as if the
        // reset itself failed — report and continue.
        try {
            $this->logCourseReset($store, $data, $selectedUserIds, $affectedUserIds, $causer);
        } catch (Throwable $e) {
            Log::warning('Failed to log course-reset activity', [
                'store_id' => $store->id,
                'message' => $e->getMessage(),
            ]);
        }

        if ($affectedUserIds->isNotEmpty()) {
            try {
                dispatch(new SendCoursesResetNotifications($affectedUserIds, tenant()->name));
            } catch (Throwable $e) {
                Log::warning('Failed to dispatch course-reset notifications', [
                    'store_id' => $store->id,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * @param  Collection<int, int>  $selectedUserIds
     * @param  Collection<int, int>  $affectedUserIds
     */
    private function logCourseReset(
        Store $store,
        ResetCoursesData $data,
        Collection $selectedUserIds,
        Collection $affectedUserIds,
        ?User $causer,
    ): void {
        $description = $data->isSelectedUsers()
            ? "Course results reset for selected users at {$store->name}"
            : "All course results reset at {$store->name}";

        $properties = [
            'reset_scope' => $data->mode,
            'store_id' => $store->id,
            'selected_user_count' => $selectedUserIds->count(),
            'affected_user_count' => $affectedUserIds->count(),
            'tenant_id' => tenant()?->id,
        ];

        if ($selectedUserIds->isNotEmpty()) {
            $properties['selected_user_ids'] = $selectedUserIds->all();
        }

        activity()
            ->causedBy($causer)
            ->performedOn($store)
            ->withProperties($properties)
            ->log($description);
    }
}
