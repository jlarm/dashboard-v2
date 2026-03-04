<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Component;

class IndexItem extends Component
{
    public User $user;
    public int $totalCourses;
    public $completed;

    public function mount(): void
    {
        $this->totalCourses = $this->totalCourses();

        $this->completed = $this->completedCourseCount();
    }

    public function render(): View
    {
        return view('livewire.central.employee.index-item');
    }

    private function totalCourses(): int
    {
        return Course::query()->count() - 1;
    }

    private function completedCourseCount(): int
    {
        if (! Schema::hasTable('course_results')) {
            return 0;
        }

        return DB::table('course_results')
            ->where('user_id', $this->user->id)
            ->whereBetween('created_at', [now()->subYear(), now()])
            ->latest()
            ->get()
            ->groupBy('course_id')
            ->map(fn ($item) => $item->firstWhere('passed', 1))
            ->count();
    }
}
