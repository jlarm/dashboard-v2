<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use WireElements\Pro\Components\Modal\Modal;

class ResendInvite extends Modal
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

    public function render()
    {
        return view('livewire.dealer.employee.resend-invite');
    }
}
