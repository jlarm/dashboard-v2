<?php

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use WireElements\Pro\Components\Modal\Modal;

class DeleteInvite extends Modal
{
    public $invite;

    public function mount(Invite $invite)
    {
        $this->invite = $invite;
    }

    public function deleteInvite()
    {
        Invite::destroy($this->invite->id);

        $this->emitTo('dealer.employee.open-invites', 'refreshOpenInvites');

        $this->close();
    }
    public function render()
    {
        return view('livewire.dealer.employee.delete-invite');
    }
}
