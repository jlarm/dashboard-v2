<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\View\View;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public OshaAudit $oshaAudit;
    public string $rating = '';
    protected array $exclude = [7, 21, 62];

    public function mount(): void
    {
        $sum = 0;
        $total = 62;

        for ($i = 1; $i <= 65; $i++) {
            if (! in_array($i, $this->exclude) && $this->oshaAudit->{'osha_q'.$i.'_answer'} === 2) {
                $sum++;
            }
        }

        $this->rating = number_format(100 * ($total - $sum) / $total, 2, '.', '');
    }

    public function render(): View
    {
        return view('livewire.dealer.audit.osha.generated-report-index-item');
    }
}
