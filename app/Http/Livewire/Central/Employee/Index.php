<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\Employee;

use App\Models\Course;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render(): View
    {
        $users = $this->getUsers();

        return view('livewire.central.employee.index', [
            'users' => $users,
            'totalCourses' => $this->totalCourses(),
            'completedCounts' => $this->completedCounts($users->pluck('id')),
        ]);
    }

    private function getUsers(): LengthAwarePaginator
    {
        return User::query()
            ->search('name', $this->search)
            ->orderBy('name')
            ->with(['roles'])
            ->paginate(20);
    }

    private function totalCourses(): int
    {
        return Course::query()->count() - 1;
    }

    private function completedCounts(Collection $userIds): Collection
    {
        if (! Schema::hasTable('course_results')) {
            return collect();
        }

        return DB::table('course_results')
            ->whereIn('user_id', $userIds)
            ->whereBetween('created_at', [now()->subYear(), now()])
            ->where('passed', 1)
            ->select('user_id', 'course_id')
            ->distinct()
            ->get()
            ->groupBy('user_id')
            ->map->count();
    }
}
