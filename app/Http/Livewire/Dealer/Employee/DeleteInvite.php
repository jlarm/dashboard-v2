<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Employee;

use App\Models\Dealer\Invite;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use WireElements\Pro\Components\Modal\Modal;

class DeleteInvite extends Modal
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

    public function deleteInvite(): void
    {
        if (! $this->invite instanceof Invite) {
            $this->close();

            return;
        }

        Invite::destroy($this->invite->id);

        $this->dispatch('refreshOpenInvites')->to('dealer.employee.open-invites');

        $this->close();
    }

    public function render(): Factory|View
    {
        return view('livewire.dealer.employee.delete-invite');
    }
}
