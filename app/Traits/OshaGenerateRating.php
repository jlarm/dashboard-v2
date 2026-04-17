<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;

trait OshaGenerateRating
{
    public Store $store;
    public $audits;
    protected int $sum = 0;
    protected $exclude = [7, 21, 62];

    public function rating(): ?string
    {
        $this->audits = OshaAudit::query()->where('pdf_path', '!=')
            ->get();

        $this->audits->filter(function ($value): void {
            for ($i = 1; $i <= 65; $i++) {
                if (! in_array($i, $this->exclude) && $value->{'osha_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });
        $total = count($this->audits) * 62;
        $wrong = $this->sum;
        if ($total > 0) {
            return $rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
        }

        return null;
    }
}
