<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public OshaAudit $oshaAudit;
    public $rating;
    public $audit;
    protected $sum;
    protected $exclude = [7, 21, 62];

    public function mount(): void
    {
        $this->sum = 0;
        $this->audit = OshaAudit::query()->where('id', $this->oshaAudit->id)->get();
        $this->audit->each(function ($value): void {
            for ($i = 1; $i <= 65; $i++) {
                if (! in_array($i, $this->exclude) && $value->{'osha_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audit) * 62;
        $this->rating = number_format(100 * ($total) / $total, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.generated-report-index-item');
    }
}
