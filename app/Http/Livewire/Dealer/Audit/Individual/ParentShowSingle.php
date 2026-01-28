<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class ParentShowSingle extends Component
{
    public IndividualAudit $individualAudit;
    public Store $store;
    public $children;
    protected $listeners = ['refreshParentComponent' => '$refresh'];

    public function mount()
    {
        $this->children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->count();
    }

    public function delete()
    {
        $this->individualAudit->delete();

        return redirect()->route('dealer.audit.individual.index');
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.parent-show-single');
    }
}
