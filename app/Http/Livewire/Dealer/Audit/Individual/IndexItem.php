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
    public $deals;
    public $sum;
    public $rating;
    public $flat;
    public $test;

    public function mount()
    {
        $combine = collect([$this->individualAudit, $this->individualAudit->children]);
        $this->flat = $combine->flatten();
        $this->tenants = tenant('locations');

        $this->test = $this->flat->pluck('rating');

        if ($this->test->contains(null)){
            $this->rating = 0;
        } else {
            $this->rating = $this->test->avg();
        }
    }

    public function getQuarterNameAttribute()
    {
        if ($this->individualAudit->audit_date->format('m') >= 1 && $this->individualAudit->audit_date->format('m') <= 3){
            return 'Q1';
        } elseif ($this->individualAudit->audit_date->format('m') >= 4 && $this->individualAudit->audit_date->format('m') <= 6){
            return 'Q2';
        } elseif ($this->individualAudit->audit_date->format('m') >= 7 && $this->individualAudit->audit_date->format('m') <= 9){
            return 'Q3';
        } elseif ($this->individualAudit->audit_date->format('m') >= 10 && $this->individualAudit->audit_date->format('m') <= 12){
            return 'Q4';
        }
    }


    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
