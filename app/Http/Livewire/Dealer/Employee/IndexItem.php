<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class IndexItem extends Component
{
    public User $user;

    public function mount()
    {
        $this->user = User::find($this->user->id);
    }
    public function render()
    {
        return view('livewire.dealer.employee.index-item');
    }
}
