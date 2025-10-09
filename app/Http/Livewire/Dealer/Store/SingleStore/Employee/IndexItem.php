<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public $completed;
    public $totalCourses;
    public $departmentCourseCount;
    public $unassignedCourseCount;
    public $courseWithRole;

    public function mount(): void
    {
        $this->initializeUser();
        $this->initializeCourseWithRole();
        $this->calculateCompletedCourses();
        $this->calculateTotalCourses();
    }

    public function render(): View
    {
        return view('livewire.dealer.store.single-store.employee.index-item', [
            'department' => Department::find($this->user->department_id),
        ]);
    }

    private function initializeUser(): void
    {
        $this->user = User::find($this->user->id);
    }

    private function initializeCourseWithRole(): void
    {
        $userRole = $this->user->roles()->select('id')->first();

        if ($userRole) {
            $this->courseWithRole = DB::table('course_role')
                ->where('role_id', $userRole->id)
                ->pluck('course_id')
                ->toArray();
        } else {
            $this->courseWithRole = [];
        }
    }

    private function calculateCompletedCourses(): void
    {
        $this->completed = DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->where('created_at', '>=', now()->subYear())
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(fn ($item) => $item->first())
            ->count();
    }

    private function calculateTotalCourses(): void
    {
        $this->totalCourses = Course::query()
            ->whereHas('departments', fn ($query) => $query->where('id', $this->user->department_id))
            ->whereIn('id', $this->courseWithRole)
            ->orWhereDoesntHave('departments')
            ->where('name', '!=', 'Sexual Harassment Training in California')
            ->with(['results' => fn ($query) => $query->where('user_id', $this->user->id)->latest()])
            ->count();

        if ($this->user->stores[0]->state !== 'California') {
            $this->totalCourses -= 1;
        }
    }
}
