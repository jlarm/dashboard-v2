<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Finance;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class GeneratedReportIndexItem extends Component
{
    public FinanceAudit $financeAudit;
    public Store $store;
    public string $rating = '';

    #[Override]
    protected $listeners = [
        'refreshFinanceAudits' => '$refresh',
    ];

    public function mount(): void
    {
        $sum = 0;
        $total = 46;

        for ($i = 1; $i <= $total; $i++) {
            if ($this->financeAudit->{'finance_q'.$i.'_answer'} === 2) {
                $sum++;
            }
        }

        $this->rating = number_format(100 * ($total - $sum) / $total, 2, '.', '');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.finance.generated-report-index-item');
    }
}
