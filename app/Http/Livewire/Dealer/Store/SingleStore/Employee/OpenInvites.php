<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Employee;

use App\Models\Dealer\Invite;
use App\Models\Dealer\Store;
use Livewire\Component;
use Livewire\WithPagination;

class OpenInvites extends Component
{
    use WithPagination;

    public Store $store;
    public $search = '';
    public function render()
    {
        return view('livewire.dealer.store.single-store.employee.open-invites', [
            'invites' => Invite::query()
                ->whereJsonContains('stores', (string)$this->store->id)
                ->where('registered_at', null)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->search('name', $this->search)
                ->paginate(10),
        ])->layout('components.dealer-app');
    }
}
