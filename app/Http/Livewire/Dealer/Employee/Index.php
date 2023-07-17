<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        return view('livewire.dealer.employee.index', [
            'users' => User::latest()
                ->whereNot('name', 'Terry Dortch')
                ->whereNot('name', 'Mike Backer')
                ->whereNot('name', 'Joe Lohr')
                ->search('name', $this->search)
                ->paginate(10),
        ]);
    }
}
