<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class ParentShowSingle extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $children;

    public function mount()
    {
        $this->children = $this->individualAudit
            ->where('store_id', $this->store->id)
            ->where('parent_id', $this->individualAudit->id)
            ->count();
    }

    public function delete()
    {
        $this->individualAudit->delete();

        return redirect()->route('dealer.stores.audits.individual.index', $this->store->slug);
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.audit.individual.parent-show-single');
    }
}
