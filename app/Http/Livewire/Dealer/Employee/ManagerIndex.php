<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Auth;
use Livewire\Component;

class ManagerIndex extends Component
{
    public function render()
    {
        return view('livewire.dealer.employee.manager-index', [
            'users' => User::query()
                ->select('id', 'name', 'email', 'phone', 'department_id')
                ->where('department_id', Auth::user()->department_id)
                ->with('department')
                ->with('roles')
//                ->with('results', function($query) {
//                    $query->where('user_id', $this->user->id)->latest();
//                })
                ->paginate(10),
        ]);
    }
}
