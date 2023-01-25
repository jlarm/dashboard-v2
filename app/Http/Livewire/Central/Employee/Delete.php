<?php

namespace App\Http\Livewire\Central\Employee;

use App\Models\User;
use WireElements\Pro\Components\Modal\Modal;
use WireElements\Pro\Concerns\InteractsWithConfirmationModal;

class Delete extends Modal
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function delete()
    {
        User::destroy($this->user->id);

        $this->close();
    }
    public function render()
    {
        return view('livewire.central.employee.delete');
    }
}
