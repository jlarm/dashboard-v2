<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\Store;
use Livewire\Component;

class SingleStoreFinanceAudit extends Component
{
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store-finance-audit')->layout('components.dealer-app');
    }
}
