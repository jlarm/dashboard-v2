<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Store $store;

    public $search = '';
    public $selectedDepartment = null;
    public $selectedDepartmentName = null;
    public $showIncompleteCourseUsers = false;

    public function getUsersQueryProperty()
    {
        return $this->store->users()
            ->whereNotIn('name', ['Joe Lohr','Terry Dortch','Mike Backer'])
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
            $users = $this->usersQuery->paginate(500)->filter(function ($user) {
                return $user->user_has_not_completed_courses;
            });
        }

        return view('livewire.dealer.store.single-store.employee.index', [
            'users' => $users,
            'departments' => Department::whereHas('users')->orderBy('name')->get(),
            $this->selectedDepartmentName = Department::where('id', $this->selectedDepartment)->first()->name ?? null,
        ])->layout('components.dealer-app');
    }
}
