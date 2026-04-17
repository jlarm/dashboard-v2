<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;

class ResendInvite extends Modal
{
    public ?Invite $invite = null;

    public function mount(int $inviteId): void
    {
        $this->invite = Invite::query()->find($inviteId);

        if (! $this->invite) {
            $this->close();
            $this->skipRender();
        }
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.resend-invite');
    }
}
