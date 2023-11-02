<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Department;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $store;
    public $selectedDepartment = null;
    public $selectedDepartmentName = null;
    public $showIncompleteCourseUsers = false;

    public function getUsersQueryProperty()
    {
        return User::query()
            ->whereNotIn('name', ['Joe Lohr','Terry Dortch','Mike Backer'])
            ->userStore($this->store ?? null)
            ->select(['id', 'name', 'slug', 'email', 'department_id'])
            ->with('roles', 'department', 'stores', 'courses')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Consultant');
            })
            ->when($this->selectedDepartment, function ($query) {
                $query->where('department_id', $this->selectedDepartment);
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

    public function resetSelectedDepartment()
    {
        $this->selectedDepartment = null;
    }

    public function resetFilters()
    {
        $this->reset(['showIncompleteCourseUsers', 'selectedDepartment']);
    }

    public function render()
    {
        $users = $this->usersQuery->paginate(25);

        if ($this->showIncompleteCourseUsers) {
            $users = $this->usersQuery
                ->when($this->selectedDepartment, function ($query) {
                    $query->where('department_id', $this->selectedDepartment);
                })
                ->paginate(500)
                ->filter(function ($user) {
                    return $user->user_has_not_completed_courses;
                });
        }

        return view('livewire.dealer.employee.index', [
            'users' => $users,
            'departments' => Department::whereHas('users')->orderBy('name')->get(),
            $this->selectedDepartmentName = Department::where('id', $this->selectedDepartment)->first()->name ?? null,
        ]);
    }
}
