<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\View\View;
use Livewire\Component;

class CourseResults extends Component
{
    public User $user;
    protected $listeners = ['refreshEmployeeDetails' => 'refreshDetails'];

    public function refreshDetails(): void
    {
        $this->user->refresh();
        $this->user->clearCourseCache();
    }

    public function render(): View
    {
        $service = app(UserCourseService::class);
        $courses = $service->getCoursesWithResults($this->user);
        $store = $this->user->stores->first() ?? Store::query()->first();

        return view('livewire.dealer.employee.course-results', [
            'courses' => $courses,
            'store' => $store,
        ]);
    }
}
