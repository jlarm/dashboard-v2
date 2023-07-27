<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;

class Show extends Component
{
    public IndividualAudit $individualAudit;
    public $audits;
    public $children;
    protected $sum;
    public $rating;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->audits = collect([$this->individualAudit, ...$this->individualAudit->children]);

//        $this->audits = $this->individualAudit->where('parent_id', $this->individualAudit->id)->get();
//        $this->children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->count();
    }

    public function delete()
    {
        $this->individualAudit->delete();

        return redirect()->route('dealer.audit.individual.index');
    }
    public function render()
    {
        return view('livewire.dealer.audit.individual.show');
    }
}
