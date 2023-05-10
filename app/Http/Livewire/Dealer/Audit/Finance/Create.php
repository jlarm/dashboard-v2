<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Store;
use Livewire\Component;

class Create extends Component
{
    public Store $store;
    public function mount()
    {
        return redirect()->to(route('dealer.stores.audits.finance.index'));
    }

}
