<?php

namespace  App\Traits;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;

trait OshaGenerateRating
{
    public Store $store;
    protected int $sum = 0;
    public $audits;
    protected $exclude = [7,21,62];

    public function rating()
    {
        $this->audits = OshaAudit::where('pdf_path', '!=', null)
            ->get();

        $this->audits->filter(function ($value) {
            for ($i = 1; $i <= 65; $i++) {
                if (!in_array($i, $this->exclude) && $value->{'osha_q' . $i .'_answer'} == 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 62;
        $wrong = $this->sum;
        if($total > 0) {
            return $rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        }
    }
}
