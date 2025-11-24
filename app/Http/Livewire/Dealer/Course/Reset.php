<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Reset extends Modal
{
    use AuthorizesRequests;
    use InteractsWithConfirmationModal;

    public ?Store $store = null;

    public function resetCourses(): void
    {
        $this->authorize('reset-courses', CourseResults::class);

        $this->askForConfirmation(
            callback: function () {
                $affectedUserIds = match (true) {
                    ! tenant('locations') => $this->deleteAllCourseResults(),
                    tenant('locations') && ! $this->store => $this->deleteAllCourseResults(),
                    tenant('locations') && $this->store => $this->deleteStoreCourseResults(),
                    default => collect()
                };

                $this->logCourseReset();

                if ($affectedUserIds->isNotEmpty()) {
                    SendCoursesResetNotifications::dispatch(
                        $affectedUserIds,
                        tenant()->name
                    );
                }

                Notification::make()
                    ->title('Courses Reset Successfully')
                    ->success()
                    ->send();
            },
            prompt: [
                'message' => __('Are you sure you want to reset all courses?'),
            ]
        );
    }

    public function render(): View
    {
        return view('livewire.dealer.course.reset');
    }

    private function deleteAllCourseResults(): Collection
    {
        $affectedUserIds = collect();

        CourseResults::query()->chunkById(100, function ($results) use ($affectedUserIds) {
            $results->each(function ($result) use ($affectedUserIds) {
                $affectedUserIds->push($result->user_id);
                $result->delete();
            });
        });

        $uniqueUserIds = $affectedUserIds->unique();
        $this->clearCacheForUsers($uniqueUserIds);

        return $uniqueUserIds;
    }

    private function deleteStoreCourseResults(): Collection
    {
        if (! $this->store) {
            return collect();
        }

        $userIds = $this->store->users()->pluck('id');

        if ($userIds->isEmpty()) {
            return collect();
        }

        $affectedUserIds = collect();

        CourseResults::query()
            ->whereIn('user_id', $userIds)
            ->chunkById(100, function ($results) use ($affectedUserIds) {
                $results->each(function ($result) use ($affectedUserIds) {
                    $affectedUserIds->push($result->user_id);
                    $result->delete();
                });
            });

        $uniqueUserIds = $affectedUserIds->unique();
        $this->clearCacheForUsers($uniqueUserIds);

        return $uniqueUserIds;
    }

    private function clearCacheForUsers(Collection $userIds): void
    {
        User::whereIn('id', $userIds)->chunkById(100, function ($users) {
            $users->each(function ($user) {
                $user->clearCourseCache();
            });
        });
    }

    private function logCourseReset(): void
    {
        $user = auth()->user();
        $description = $this->store
            ? "Course results reset for store: {$this->store->name}"
            : 'All course results reset';

        $properties = [
            'store_id' => $this->store?->id,
            'store_name' => $this->store?->name,
            'reset_scope' => $this->store ? 'store' : 'all',
            'tenant_id' => tenant()?->id,
        ];

        activity()
            ->causedBy($user)
            ->withProperties($properties)
            ->log($description);
    }
}
