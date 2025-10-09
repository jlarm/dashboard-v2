<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Show extends Component
{
    public Store $store;
    public OshaAudit $oshaAudit;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.osha.show')->layout('components.dealer-app');
    }
}
