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


    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
