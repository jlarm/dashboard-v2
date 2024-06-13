<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use App\Traits\BodyShopGenerateRating;
use App\Traits\HasAuditStats;
use Livewire\Component;

class BodyShopStats extends Component
{
    use BodyShopGenerateRating, HasAuditStats;

    public Store $store;

    public $audits;

    public $dates;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();
    }

    private function violationAudits()
    {
        return BodyShopViolationAudit::query()->where('store_id', $this->store->id);
    }

    private function convertRatingToGrade()
    {
        $avg = BodyShopAudit::query()
            ->where('store_id', $this->store->id)
            ->where('rating', '!=', null)
            ->where('rating', '!=', 'N/A')
            ->pluck('rating')
            ->average();

        if ($avg === null) {
            return;
        }

        return match (true) {
            $avg >= 90 && $avg <= 100 => 'A',
            $avg >= 80 && $avg <= 89 => 'B',
            $avg >= 70 && $avg <= 79 => 'C',
            $avg >= 60 && $avg <= 69 => 'D',
            default => 'F',
        };

    }

    private function grades(): array
    {
        $grades = $this->violationAudits()
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->pluck('grade')
            ->toArray();

        if ($this->convertRatingToGrade() !== null) {
            $grades[] = $this->convertRatingToGrade();
        }

        return $grades;
    }

    public function rating(): string
    {
        $gradesCount = count($this->grades());
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $total = 0;

        foreach ($this->grades() as $grade) {
            $total += $gradeValues[$grade];
        }

        if ($gradesCount == 0) {
            return 'N/A';
        } else {
            $avg = $total / count($this->grades());
        }

        return match (true) {
            $avg >= 3.5 && $avg <= 4 => 'A',
            $avg >= 2.5 && $avg <= 3.4 => 'B',
            $avg >= 1.5 && $avg <= 2.4 => 'C',
            $avg >= 0.5 && $avg <= 1.4 => 'D',
            $avg >= 0 && $avg <= 0.4 => 'F',
            default => 'N/A',
        };
    }

    public function render()
    {
        return view('livewire.dealer.home.body-shop-stats');
    }
}
