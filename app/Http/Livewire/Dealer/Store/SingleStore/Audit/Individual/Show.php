<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class Show extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $parent;
    public $children;
    public $draftCount;

    public function mount()
    {
        $this->children = IndividualAudit::query()
            ->where('store_id', $this->store->id)
            ->where('parent_id', $this->individualAudit->id)
            ->where('draft', 1)
            ->count();
        $this->parent = IndividualAudit::where('id', $this->individualAudit->id)->where('draft', 1)->count();
        $this->draftCount = $this->children + $this->parent;
    }
    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.individual.show', [
            'audits' => $this->individualAudit->children()->with('store')->get(),
            'drafts' => $this->draftCount,
        ])->layout('components.dealer-app');
    }
}
