<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class CourseResults extends Component
{
    public User $user;

    #[Override]
    protected $listeners = ['refreshEmployeeDetails' => 'refreshDetails'];

    public function refreshDetails(): void
    {
        $this->user->refresh();
        $this->user->clearCourseCache();
    }

    public function render(): View
    {
        $service = resolve(UserCourseService::class);
        $courses = $service->getCoursesWithResults($this->user);
        $store = Store::query()->find((int) resolve('currentStore')) ?? Store::query()->first();

        return view('livewire.dealer.employee.course-results', [
            'courses' => $courses,
            'store' => $store,
        ]);
    }
}
