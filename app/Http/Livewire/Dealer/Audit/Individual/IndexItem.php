<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class IndexItem extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $drafts;

    public function mount()
    {
        $this->drafts = $this->individualAudit->children()->where('draft', true)->count();
    }

    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
