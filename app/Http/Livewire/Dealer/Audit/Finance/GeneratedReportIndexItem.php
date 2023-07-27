<?php

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public FinanceAudit $financeAudit;
    public Store $store;
    public $rating;
    protected $sum;
    protected $audit;

    protected $listeners = [
        'refreshFinanceAudits' => '$refresh',
    ];

    public function mount()
    {
        $this->audit = FinanceAudit::where('id', $this->financeAudit->id)->get();
        $this->audit->filter(function ($value) {
            for ($i = 1; $i <= 46; $i++) {
                if ($value->{'finance_q' . $i .'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audit) * 46;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }
    public function render()
    {
        return view('livewire.dealer.audit.finance.generated-report-index-item');
    }
}
