<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.central.employee.view');
    }
}
