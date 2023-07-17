<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Store;
use App\Models\User;
use Auth;
use Livewire\Component;

class ManagerIndex extends Component
{
    public $store;
    public $search = '';

    public function mount()
    {
        $this->store = Store::whereHas('users', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->pluck('id')->first();
    }

    public function render()
    {
        return view('livewire.dealer.employee.manager-index', [
            'users' => User::query()
                ->whereNot('name', 'Terry Dortch')
                ->whereNot('name', 'Mike Backer')
                ->whereNot('name', 'Joe Lohr')
                ->select('id', 'name', 'email', 'phone', 'department_id')
                ->where('department_id', auth()->user()->department_id)
                ->when($this->store, function ($query, $store) {
                    $query->whereHas('stores', function ($query) use ($store) {
                        $query->where('store_id', $store);
                    });
                })
                ->with('department')
                ->with('roles')
                ->search('name', $this->search)
                ->paginate(10),
        ]);
    }
}
