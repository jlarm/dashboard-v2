<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Store $store;

    public $search = '';
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
            ->currentUserIsManager(auth()->user())
            ->search('name', $this->search);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingShowIncompleteCourseUsers()
    {
        $this->resetPage();
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
        ])->layout('components.dealer-app');
    }
}
