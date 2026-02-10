<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\Multi;

use App\Models\Dealer\Course;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EmployeeIndexItem extends Component
{
    public User $user;
    public Store $store;
    public int $completed;
    public int $totalCourses;
    public array $courseWithRole;

    public function mount(): void
    {
        $userRoleIds = $this->user->roles->pluck('id')->toArray();
        $this->courseWithRole = DB::table('course_role')->whereIn('role_id', $userRoleIds)->pluck('course_id')->toArray();

        // Get all passed courses within the last year for this user
        $this->completed = DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->where('created_at', '>=', now()->subYear())
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(fn ($item) => $item->first());

        $this->completed = collect($this->completed->where('passed', 1))->count();

        // Get all courses for this user's department
        $this->totalCourses = Course::query()
            ->WhereHas('departments', function ($query): void {
                $query->where('id', $this->user->department_id);
            })
            ->whereIn('id', $this->courseWithRole)
            ->orWhereDoesntHave('departments')
            ->with([
                'results' => function ($query): void {
                    $query->where('user_id', $this->user->id)->latest();
                },
            ])->count();
    }

    public function render()
    {
        return view('livewire.dealer.store.multi.employee-index-item');
    }
}
