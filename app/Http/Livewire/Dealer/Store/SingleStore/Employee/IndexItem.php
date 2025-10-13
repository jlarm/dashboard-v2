<?php

declare(strict_types=1);

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
    public int $completed;
    public int $totalCourses;
    public $departmentCourseCount;
    public $unassignedCourseCount;
    public array $courseWithRole;

    public function mount(): void
    {
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

    private function initializeCourseWithRole(): void
    {
        $userRoleIds = $this->user->roles->pluck('id')->toArray();

        if (count($userRoleIds) > 0) {
            $this->courseWithRole = DB::table('course_role')
                ->whereIn('role_id', $userRoleIds)
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
