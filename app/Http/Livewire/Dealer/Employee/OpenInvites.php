<?php

namespace App\Http\Livewire\Dealer\Employee;

use Livewire\Component;
use App\Models\Dealer\Invite;
use Livewire\WithPagination;

class OpenInvites extends Component
{
    use WithPagination;
    protected $listeners = ['refreshOpenInvites' => '$refresh'];
    public function render()
    {
        return view('livewire.dealer.employee.open-invites', [
            'invites' => Invite::where('registered_at', null)
                ->with('user')
                ->with('store')
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
