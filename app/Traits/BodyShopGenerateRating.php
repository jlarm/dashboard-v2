<?php

namespace App\Traits;

use App\Models\Dealer\Audit\BodyShopAudit;

trait BodyShopGenerateRating
{
    public $audits;
    protected int $sum = 0;

    public function rating()
    {
        $this->audits = cache()->remember('body_shop_stats', 60 * 60 * 24, function () {
            return BodyShopAudit::where('pdf_path', '!=', null)
                ->get();
        });
        $this->audits->filter(function ($value) {
            for ($i = 1; $i <= 43; $i++) {
                if ($value->{'body_shop_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 43;
        $wrong = $this->sum;
        if ($total > 0) {
            return $rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        }
    }
}
