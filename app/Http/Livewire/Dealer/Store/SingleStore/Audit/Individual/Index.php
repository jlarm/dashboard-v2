<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Index extends Component
{
    public Store $store;

    protected $listeners = [
        'refreshIndividualAudits' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.individual.index', [
            'individualAudits' => IndividualAudit::where('store_id', $this->store->id)->orderBy('created_at', 'desc')->get()
        ])->layout('components.dealer-app');
    }
}
