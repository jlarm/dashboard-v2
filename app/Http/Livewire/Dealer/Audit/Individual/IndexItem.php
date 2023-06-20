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
    public $tenants;

    public function mount()
    {
        $this->tenants = tenant('locations');
        $children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->where('draft', 1)->count();
        $parent = $this->individualAudit->draft == 1 ? 1 : 0;
        $this->drafts = $children + $parent;
    }

    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
