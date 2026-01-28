<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexItem extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.individual.index-item')->layout('components.dealer-app');
    }
}
