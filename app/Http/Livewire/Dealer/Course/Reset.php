<?php

namespace App\Http\Livewire\Dealer\Course;

use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Reset extends Modal
{
    use InteractsWithConfirmationModal;

    public ?Store $store = null;

    public function resetCourses(): void
    {
        $this->askForConfirmation(
            callback: function () {
                match (true) {
                    ! tenant('locations') => $this->deleteAllCourseResults(),
                    tenant('locations') && ! $this->store => $this->deleteAllCourseResults(),
                    tenant('locations') && $this->store => $this->deleteStoreCourseResults(),
                    default => null
                };

                // Log the course reset activity
                $this->logCourseReset();

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

    private function deleteAllCourseResults(): void
    {
        $affectedUserIds = collect();

        CourseResults::query()->chunkById(100, function ($results) use ($affectedUserIds) {
            $results->each(function ($result) use ($affectedUserIds) {
                $affectedUserIds->push($result->user_id);
                $result->delete();
            });
        });

        // Clear cache for all affected users
        $this->clearCacheForUsers($affectedUserIds->unique());
    }

    private function deleteStoreCourseResults(): void
    {
        if (! $this->store) {
            return;
        }

        $userIds = $this->store->users()->pluck('id');

        if ($userIds->isEmpty()) {
            return;
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

        // Clear cache for all affected users
        $this->clearCacheForUsers($affectedUserIds->unique());
    }

    /**
     * Clear the course cache for the specified users.
     */
    private function clearCacheForUsers($userIds): void
    {
        User::whereIn('id', $userIds)->chunkById(100, function ($users) {
            $users->each(function ($user) {
                $user->clearCourseCache();
            });
        });
    }

    /**
     * Log the course reset activity using Spatie Activity Log.
     */
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
