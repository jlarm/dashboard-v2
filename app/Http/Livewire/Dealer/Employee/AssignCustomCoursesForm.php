<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AssignCustomCoursesForm extends Component
{
    public User $user;
    public $courses;
    public $courseStates = [];
    public $defaultCourseIds = [];
    public bool $isLoaded = false;
    protected $listeners = ['employeeTabChanged' => 'handleTabChanged'];

    public function mount(): void
    {
        $this->courses = collect();
    }

    public function handleTabChanged(string $tab): void
    {
        if ($tab !== 'manage-courses' || $this->isLoaded) {
            return;
        }

        $this->loadData();
        $this->isLoaded = true;
    }

    public function setCourseState($courseId, $state): void
    {
        $courseId = (int) $courseId;
        $currentUser = Auth::user();

        // Update the courseStates array
        $this->courseStates[$courseId] = $state;

        // Remove any existing override
        $this->user->courses()->wherePivot('course_id', $courseId)->detach();

        // Add new override if not default
        if ($state === 'add') {
            $this->user->courses()->attach($courseId, [
                'type' => 'add',
                'assigned_by' => $currentUser->id,
            ]);
        } elseif ($state === 'exclude') {
            $this->user->courses()->attach($courseId, [
                'type' => 'exclude',
                'assigned_by' => $currentUser->id,
            ]);
        }

        // Clear course cache and refresh user
        $this->user->clearCourseCache();
        $this->user->refresh();

        // Clear department completion stats cache
        $this->clearDepartmentStatsCache();

        $this->emit('refreshEmployeeDetails');
    }

    public function updatedCourseStates($value, $key): void
    {
        $this->setCourseState((int) $key, $value);
    }

    public function render()
    {
        return view('livewire.dealer.employee.assign-custom-courses-form');
    }

    protected function clearDepartmentStatsCache(): void
    {
        $tenantId = tenant('id') ?? 'no-tenant';
        $storeIds = [];

        try {
            $storeIds = Store::query()->pluck('id')->toArray();
        } catch (Exception) {
            $storeIds = [];
        }

        foreach ($storeIds as $storeId) {
            Cache::forget("department_completion_stats_{$storeId}_{$tenantId}");
        }

        Cache::forget("department_completion_stats_all_{$tenantId}_admin");

        try {
            $allUsers = User::with('stores')->get();
            foreach ($allUsers as $user) {
                if (! $user->hasAnyRole(['super-admin', 'Consultant'])) {
                    $userStoreIds = $user->stores->pluck('id')->sort()->implode('_');
                    Cache::forget("department_completion_stats_all_{$tenantId}_user_{$userStoreIds}");
                }
            }
        } catch (Exception) {
        }
    }

    private function loadData(): void
    {
        // Get all courses ordered by name
        $this->courses = Course::query()
            ->orderBy('name')
            ->select(['id', 'name'])
            ->get();

        // Get courses that would be assigned by default using the service
        $service = app(UserCourseService::class);
        $this->defaultCourseIds = $service->getCourseIds($this->user);

        // Get user's custom course overrides
        $userCourseOverrides = $this->user->courses()
            ->wherePivot('type', 'add')
            ->orWherePivot('type', 'exclude')
            ->get()
            ->keyBy('id');

        // Initialize courseStates array
        foreach ($this->courses as $course) {
            $override = $userCourseOverrides->get($course->id);

            if ($override) {
                $pivotType = $override->pivot->getAttribute('type');
                $this->courseStates[$course->id] = $pivotType === 'add' ? 'add' : 'exclude';
            } else {
                $this->courseStates[$course->id] = 'default';
            }
        }
    }
}
