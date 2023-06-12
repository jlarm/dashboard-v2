<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;

class ParentShowSingle extends Component
{
    public IndividualAudit $individualAudit;
    public $children;

    protected $listeners = ['refreshParentComponent' => '$refresh'];

    public function mount()
    {
        $this->children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->count();
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.parent-show-single');
    }
}
