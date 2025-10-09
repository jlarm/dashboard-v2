<?php

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

    public function mount()
    {
        $this->audit = OshaAudit::where('id', $this->oshaAudit->id)->get();
        $this->audit->filter(function ($value) {
            for ($i = 1; $i <= 65; $i++) {
                if (! in_array($i, $this->exclude) && $value->{'osha_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audit) * 62;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }

    public function render()
    {
        return view('livewire.dealer.audit.osha.generated-report-index-item');
    }
}
