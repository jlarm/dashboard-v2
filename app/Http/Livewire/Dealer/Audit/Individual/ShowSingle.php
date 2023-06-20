<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class ShowSingle extends Component
{
    public Store $store;
    public IndividualAudit $audit;
    public function render()
    {
        return view('livewire.dealer.audit.individual.show-single');
    }
}
