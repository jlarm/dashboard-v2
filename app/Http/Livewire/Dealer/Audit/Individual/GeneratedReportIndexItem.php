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
        $this->sum = 0;
        $current = IndividualAudit::query()->where('id', $this->individualAudit->id)->get();
        $combine = collect([$current, $this->individualAudit->children]);
        $this->flat = $combine->flatten();
        //        dd($this->individualAudit->children);

        $this->flat->each(function ($value): void {
            for ($i = 3; $i <= 40; $i++) {
                if ($i !== 19 && $value->{'individual_q'.$i.'_answer'} === 2) {
                    $this->sum += 1;
                }
            }
        });

        $total = count($this->flat) * 37;
        $this->rating = number_format(100 * ($total) / $total, 2, '.', '');
    }

    public function getQuarterNameAttribute(): ?string
    {
        $month = (int) $this->individualAudit->audit_date->format('n');

        return match (true) {
            $month <= 3 => 'Q1',
            $month <= 6 => 'Q2',
            $month <= 9 => 'Q3',
            default => 'Q4',
        };
    }

    public function render()
    {
        return view('livewire.dealer.audit.individual.generated-report-index-item');
    }
}
