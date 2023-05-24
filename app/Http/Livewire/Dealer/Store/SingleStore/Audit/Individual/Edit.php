<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Edit extends Component
{
    public Store $store;
    public IndividualAudit $individualAudit;
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.individual.edit')->layout('components.dealer-app');
    }
}
