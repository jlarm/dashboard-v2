<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.dealer.employee.index', [
            'users' => User::latest()
                ->where('name', '!=', 'Terry Dortch')
                ->where('name', '!=', 'Mike Backer')
                ->where('name', '!=', 'Joe Lohr')
                ->paginate(10),
        ]);
    }
}
