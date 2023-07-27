<?php

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class ShowSingle extends Component
{
    public Store $store;
    public IndividualAudit $audit;
    protected $sum;
    public $rating;
    public $test;
    public $deal;

    public function mount()
    {
        $deal = IndividualAudit::where('id', $this->audit->id)->get();
        $deal->filter(function ($value) {
            for ($i = 3; $i <= 40; $i++) {
                if ($i != 19 && $value->{'individual_q' . $i .'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($deal) * 37;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.show-single');
    }
}
