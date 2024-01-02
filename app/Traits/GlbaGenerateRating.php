<?php

namespace App\Traits;

use App\Models\Dealer\Audit\FinanceAudit;

trait GlbaGenerateRating
{
    protected int $sum = 0;

    public $audits;

    public function rating()
    {
        $this->audits = cache()->remember('glba_stats', 60 * 60 * 24, function () {
            return FinanceAudit::where('pdf_path', '!=', null)
                ->get();
        });
        $this->audits->filter(function ($value) {
            for ($i = 1; $i <= 46; $i++) {
                if ($value->{'finance_q'.$i.'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 46;
        $wrong = $this->sum;
        if ($total > 0) {
            return $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        }
    }
}
