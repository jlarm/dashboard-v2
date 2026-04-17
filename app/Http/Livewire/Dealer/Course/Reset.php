<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Course;

use App\Jobs\SendCoursesResetNotifications;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Services\CourseResetService;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
            callback: function (): void {
                $affectedUserIds = resolve(CourseResetService::class)->reset(store: $this->store);

                $this->logCourseReset();

                if ($affectedUserIds->isNotEmpty()) {
                    dispatch(new SendCoursesResetNotifications($affectedUserIds, tenant()->name));
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

    private function logCourseReset(): void
    {
        $user = auth()->user();
        $description = $this->store instanceof Store
            ? "Course results reset for store: {$this->store->name}"
            : 'All course results reset';

        $properties = [
            'store_id' => $this->store?->id,
            'store_name' => $this->store?->name,
            'reset_scope' => $this->store instanceof Store ? 'store' : 'all',
            'tenant_id' => tenant()?->id,
        ];

        activity()
            ->causedBy($user)
            ->withProperties($properties)
            ->log($description);
    }
}
