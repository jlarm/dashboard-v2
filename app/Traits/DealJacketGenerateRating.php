<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Audit\IndividualAudit;

trait DealJacketGenerateRating
{
    public $audits;
    protected int $sum = 0;

    public function rating(): ?string
    {
        $this->audits = IndividualAudit::all();

        $this->audits->filter(function ($value): void {
            for ($i = 1; $i <= 43; $i++) {
                if ($value->{'individual_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 43;
        $wrong = $this->sum;
        if ($total > 0) {
            return $rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        }
        return null;
    }
}
