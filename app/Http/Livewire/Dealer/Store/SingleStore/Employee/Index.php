<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public Store $store;

    public $sid = '';
    public $search = '';
    public $showIncompleteCourses;

    protected $queryString = [
        'search' => ['except' => ''],
        'showIncompleteCourses' => ['except' => false],
    ];

    public function mount()
    {
        $this->sid = $this->store->id;
    }

    public function getUsersQueryProperty()
    {
        return Store::where('id', $this->sid)->first()->users()
            ->with('roles', 'department', 'stores')
            ->orderBy('name')
            ->whereNotIn('name', ['Terry Dortch', 'Mike Backer', 'Joe Lohr'])
            ->search('name', $this->search);
    }

    public function getUsersProperty()
    {
        if ($this->showIncompleteCourses) {
            return $this->usersQuery->get();
        }
        return $this->usersQuery
            ->paginate(10);
    }

    public function hideIncompleteCourses()
    {
        $this->showIncompleteCourses = false;
    }

    public function render()
    {
        $users = $this->users;

        if ($this->showIncompleteCourses) {
            $users = $users->filter(function ($user) {
                return $user->user_has_not_completed_courses;
            });
        }

        return view('livewire.dealer.store.single-store.employee.index', [
            'users' => $users,
        ])->layout('components.dealer-app');
    }
}
