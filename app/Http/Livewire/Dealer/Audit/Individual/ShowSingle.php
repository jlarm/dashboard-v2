<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class ShowSingle extends Component
{
    public IndividualAudit $audit;
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.audit.individual.show-single');
    }
}
