<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexItem extends Component
{
    public OshaAudit $oshaAudit;
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.osha.index-item')->layout('components.dealer-app');
    }
}
