<?php

declare(strict_types=1);

namespace App\Domain\Tenant\GlobalSettings\Actions;

use App\Domain\Tenant\GlobalSettings\Data\ResetCoursesData;
use App\Domain\Tenant\GlobalSettings\Queries\GetResettableUsers;
use App\Jobs\SendCoursesResetNotifications;
use App\Models\User;
use App\Services\CourseResetService;
use Illuminate\Support\Collection;

class ResetCourses
{
    public function __construct(
        private readonly CourseResetService $courseResetService,
        private readonly GetResettableUsers $getResettableUsers,
    ) {}

    public function handle(ResetCoursesData $data, ?User $causer): void
    {
        $selectedUserIds = collect($data->selectedUserIds);

        $userIdsForReset = $data->isSelectedUsers()
            ? $selectedUserIds
            : $this->getResettableUsers->allUserIds();

        $affectedUserIds = $this->courseResetService->reset(
            store: null,
            selectedUserIds: $userIdsForReset,
        );

        $this->logCourseReset($data, $selectedUserIds, $affectedUserIds, $causer);

        if ($affectedUserIds->isNotEmpty()) {
            dispatch(new SendCoursesResetNotifications($affectedUserIds, tenant()->name));
        }
    }

    /**
     * @param  Collection<int, int>  $selectedUserIds
     * @param  Collection<int, int>  $affectedUserIds
     */
    private function logCourseReset(
        ResetCoursesData $data,
        Collection $selectedUserIds,
        Collection $affectedUserIds,
        ?User $causer,
    ): void {
        $description = $data->isSelectedUsers()
            ? 'Course results reset for selected users'
            : 'All employee course results reset';

        $properties = [
            'reset_scope' => $data->mode,
            'selected_user_count' => $selectedUserIds->count(),
            'affected_user_count' => $affectedUserIds->count(),
            'tenant_id' => tenant()?->id,
        ];

        if ($selectedUserIds->isNotEmpty()) {
            $properties['selected_user_ids'] = $selectedUserIds->all();
        }

        activity()
            ->causedBy($causer)
            ->withProperties($properties)
            ->log($description);
    }
}
