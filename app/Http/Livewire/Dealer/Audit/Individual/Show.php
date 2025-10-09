<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;

class Show extends Component
{
    public IndividualAudit $individualAudit;
    public $audits;
    public $children;
    public $rating;
    protected $sum;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->audits = collect([$this->individualAudit, ...$this->individualAudit->children]);
    }

    public function getQuarterNameAttribute()
    {
        if ($this->individualAudit->audit_date->format('m') >= 1 && $this->individualAudit->audit_date->format('m') <= 3) {
            return 'Q1';
        }
        if ($this->individualAudit->audit_date->format('m') >= 4 && $this->individualAudit->audit_date->format('m') <= 6) {
            return 'Q2';
        }
        if ($this->individualAudit->audit_date->format('m') >= 7 && $this->individualAudit->audit_date->format('m') <= 9) {
            return 'Q3';
        }
        if ($this->individualAudit->audit_date->format('m') >= 10 && $this->individualAudit->audit_date->format('m') <= 12) {
            return 'Q4';
        }
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
