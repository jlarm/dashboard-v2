<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.osha.index', [
            'audits' => OshaAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc')->get()
        ])->layout('components.dealer-app');
    }
}
