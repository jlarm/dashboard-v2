<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Traits\EmployeeCourses;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class CourseResults extends Component
{
    use WithPagination, EmployeeCourses;

    public Store $store;

    public User $user;

    private array $courseWithRole = []; // Initialize the property

    protected $listeners = ['refreshEmployeeDetails' => '$refresh'];

    public function mount(): void
    {
        $this->initializeStore();
        $this->initializeCourseWithRole();
    }

    public function render()
    {
        $courses = $this->getMainCourses()
            ->merge($this->getUserCourses())
            ->sortBy('name');

        return view('livewire.dealer.employee.course-results', [
            'courses' => $this->loadCoursesForCurrentUser($this->user)
        ]);
    }

    private function initializeStore(): void
    {
        $this->store = $this->user->stores->first() ?? Store::first();
    }

    private function initializeCourseWithRole(): void
    {
        $userRole = $this->user->roles()->pluck('id')->diff([5])->toArray();
        $this->courseWithRole = \DB::table('course_role')
            ->where('role_id', $userRole)
            ->pluck('course_id')
            ->toArray();
    }

    private function getMainCourses(): Collection
    {
        return Course::query()
            ->whereHas('departments', fn ($query) => $query->where('id', $this->user->department_id))
            ->whereIn('id', $this->courseWithRole)
            ->orWhereDoesntHave('departments')
            ->where('name', '!=', 'Sexual Harassment Training in California')
            ->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest()])
            ->orderBy('name')
            ->select(['id', 'name', 'slug']) // Ensure 'slug' is selected
            ->get();
    }

    private function getUserCourses(): Collection
    {
        return $this->user->courses()
            ->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest('id')])
            ->where('name', '!=', 'Sexual Harassment Training in California')
            ->select(['id', 'name', 'slug']) // Ensure 'slug' is selected
            ->get();
    }
}
