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

    public $showIncompleteCourseUsers = false;

    public $queryString = [
        'search' => ['except' => '', 'as' => 's'],
        'selectedDepartment' => ['except' => null, 'as' => 'd'],
        'showIncompleteCourseUsers' => ['except' => false, 'as' => 'i'],
    ];

    public function getUsersQueryProperty()
    {
        return User::query()
            ->whereNotIn('name', ['Joe Lohr', 'Terry Dortch', 'Mike Backer'])
            ->userStore($this->store ?? null)
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with('roles', 'department', 'stores', 'courses')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Consultant');
            })
            ->currentUserIsManager(auth()->user())
            ->search('name', $this->search);
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
