<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class CourseResults extends Component
{
    use WithPagination;

    public Store $store;

    public User $user;

    public $courseWithRole;

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function mount(): void
    {
        $this->store = $this->user->stores->first() ?? Store::first();
        $userRole = $this->user->roles()->pluck('id')->toArray();
        $userRole = array_diff($userRole, [5]);
        $this->courseWithRole = \DB::table('course_role')->where('role_id', $userRole)->pluck('course_id')->toArray();
    }

    public function render()
    {
        $mainCourses = Course::query()
            ->whereHas('departments', function ($query) {
                $query->where('id', $this->user->department_id);
            })
            ->whereIn('id', $this->courseWithRole)
            ->orWhereDoesntHave('departments')
            ->with([
                'results' => function ($query) {
                    $query->where('user_id', $this->user->id)
                          ->latest('id')
                          ->limit(1); // Get the latest result
                },
            ])->orderBy('name')
            ->get();

        $userCourses = $this->user->courses()->with(['results' => function ($query) {
            $query->where('user_id', $this->user->id)
                  ->latest('id')
                  ->limit(1); // Get the latest result
        }])->get();

        $courses = collect($mainCourses)->merge($userCourses)->sortBy('name');

        return view('livewire.dealer.employee.course-results', [
            'courses' => $courses,
        ]);
    }
}
