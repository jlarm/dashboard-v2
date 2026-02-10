<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Individual;

use App\Models\Dealer\Audit\IndividualAudit;
use Livewire\Component;

class GeneratedReportIndexItem extends Component
{
    public IndividualAudit $individualAudit;
    public $rating;
    public $audit;
    protected $sum;
    protected $flat;

    public function mount(): void
    {
        $current = IndividualAudit::query()->where('id', $this->individualAudit->id)->get();
        $combine = collect([$current, $this->individualAudit->children]);
        $this->flat = $combine->flatten();
        //        dd($this->individualAudit->children);

        $this->flat->filter(function ($value): void {
            for ($i = 3; $i <= 40; $i++) {
                if ($i !== 19 && $value->{'individual_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });

        $total = count($this->flat) * 37;
        $wrong = $this->sum;
        $this->rating = number_format(100 * ($total - $wrong) / $total, 2, '.', '');
    }

    public function getQuarterNameAttribute(): ?string
    {
        if ($this->individualAudit->audit_date->format('m') >= 1 && $this->individualAudit->audit_date->format('m') <= 3) {
            return 'Q1';
        }
        if ($this->individualAudit->audit_date->format('m') >= 4 && $this->individualAudit->audit_date->format('m') <= 6) {
            return 'Q2';
        }
        if ($this->individualAudit->audit_date->format('m') >= 7 && $this->individualAudit->audit_date->format('m') <= 9) {
            return 'Q3';
        }
        if ($this->individualAudit->audit_date->format('m') >= 10 && $this->individualAudit->audit_date->format('m') <= 12) {
            return 'Q4';
        }

        return null;
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.generated-report-index-item');
    }
}
