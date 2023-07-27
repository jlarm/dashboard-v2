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

    public function mount()
    {
        $combine = collect([$this->individualAudit, $this->individualAudit->children]);
        $this->flat = $combine->flatten();
        $this->tenants = tenant('locations');
        $children = $this->individualAudit->where('parent_id', $this->individualAudit->id)->where('draft', 1)->count();
        $parent = $this->individualAudit->draft == 1 ? 1 : 0;
        $this->drafts = $children + $parent;
//        $this->deals = $this->individualAudit->where('parent_id', $this->individualAudit->id)->select('individual_q4_answer', 'individual_q6_answer', 'individual_q7_answer', 'individual_q10_answer', 'individual_q11_answer', 'individual_q12_answer', 'individual_q13_answer', 'individual_q14_answer', 'individual_q15_answer', 'individual_q16_answer', 'individual_q17_answer')->get();
        $this->flat->filter(function ($value) {
            for ($i = 3; $i <= 40; $i++) {
                if ($i != 19 && $value->{'individual_q' . $i .'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->flat) * 37;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }


    protected $listeners = [
        'refreshIndividualAudits' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.dealer.audit.individual.index-item');
    }
}
