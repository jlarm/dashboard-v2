<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use WireElements\Pro\Components\Modal\Modal;

class DeleteInvite extends Modal
{
    public ?Invite $invite = null;

    public function mount(int $inviteId): void
    {
        $this->invite = Invite::find($inviteId);

        if (! $this->invite) {
            $this->close();
            $this->skipRender();
        }
    }

    public function deleteInvite(): void
    {
        if (! $this->invite) {
            $this->close();

            return;
        }

        Invite::destroy($this->invite->id);

        $this->emitTo('dealer.employee.open-invites', 'refreshOpenInvites');

        $this->close();
    }

    public function render()
    {
        return view('livewire.dealer.employee.delete-invite');
    }
}
