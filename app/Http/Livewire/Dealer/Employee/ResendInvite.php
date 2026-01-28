<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use WireElements\Pro\Components\Modal\Modal;

class ResendInvite extends Modal
{
    public $invite;

    public function mount(Invite $invite)
    {
        $this->invite = $invite;
    }

    public function render()
    {
        return view('livewire.dealer.employee.resend-invite');
    }
}
