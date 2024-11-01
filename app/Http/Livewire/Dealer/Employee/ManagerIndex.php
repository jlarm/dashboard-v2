<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManagerIndex extends Component
{
    use WithPagination;

    public $search = '';

    public $store;

    public $selectedDepartment = null;

    public $selectedDepartmentName = null;

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
            ->with('roles', 'department', 'stores', 'courses')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', ['super-admin', 'Consultant']);
            })
            ->whereHas('stores', function ($query) {
                $query->whereIn('id', auth()->user()->stores->pluck('id'));
            })
            ->where('department_id', auth()->user()->department_id)
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                    ->whereHas('stores', function ($storeQuery) {
                        $storeQuery->whereIn('id', auth()->user()->stores->pluck('id'));
                    })
                    ->where('department_id', auth()->user()->department_id);
            });
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetShowIncompleteCourseUsers()
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function updatingShowIncompleteCourseUsers()
    {
        $this->resetPage();
    }

    public function updatingSelectedDepartment()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['showIncompleteCourseUsers']);
    }

    public function render()
    {
        $users = $this->usersQuery->paginate(25);

        if ($this->showIncompleteCourseUsers) {
            $users = $this->usersQuery
                ->paginate(500)
                ->filter(function ($user) {
                    return $user->user_has_not_completed_courses;
                });
        }

        return view('livewire.dealer.employee.manager-index', [
            'users' => $users,
        ]);
    }
}
