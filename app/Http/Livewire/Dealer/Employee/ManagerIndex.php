<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * @property-read Builder $usersQuery
 */
class ManagerIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $store;
    public $selectedDepartment;
    public $selectedDepartmentName;
    public $showIncompleteCourseUsers = false;
    public $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
    ];

    public function getUsersQueryProperty()
    {
        return User::query()
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with([
                'roles',
                'department:id,name',
                'stores:id,name,state',
                'courses:id',
                'courseOverrides:user_id,course_id,type',
                'results' => function ($query): void {
                    $query->select('id', 'user_id', 'course_id', 'passed', 'created_at')
                        ->where('passed', 1);
                },
            ])
            ->whereDoesntHave('roles', function ($query): void {
                $query->where('name', 'super-admin')
                    ->orWhere('name', 'Consultant');
            })
            ->whereHas('stores', function ($query): void {
                $query->whereIn('id', auth()->user()->stores->pluck('id'));
            })
            ->where('department_id', auth()->user()->department_id)
            ->when($this->search, function ($query): void {
                $query->where(function ($subQuery): void {
                    $subQuery->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                    ->whereHas('stores', function ($storeQuery): void {
                        $storeQuery->whereIn('id', auth()->user()->stores->pluck('id'));
                    })
                    ->where('department_id', auth()->user()->department_id);
            });
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function resetShowIncompleteCourseUsers(): void
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function updatingShowIncompleteCourseUsers(): void
    {
        $this->resetPage();
    }

    public function updatingSelectedDepartment(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function render()
    {
        $users = $this->usersQuery->paginate(25);

        if ($this->showIncompleteCourseUsers) {
            $users = $this->usersQuery
                ->paginate(500)
                ->filter(fn ($user): bool => $user instanceof User && $user->user_has_not_completed_courses);
        }

        return view('livewire.dealer.employee.manager-index', [
            'users' => $users,
        ]);
    }
}
