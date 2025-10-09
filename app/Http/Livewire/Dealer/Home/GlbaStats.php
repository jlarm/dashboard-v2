<?php

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use App\Traits\GlbaGenerateRating;
use App\Traits\HasAuditStats;
use Livewire\Component;

class GlbaStats extends Component
{
    use GlbaGenerateRating, HasAuditStats;

    public Store $store;
    public $audits;
    public $dates;
    private ?array $cachedGrades = null;

    public function mount()
    {
        $this->store = $this->store ?? Store::first();
    }

    public function rating(): string
    {
        $grades = $this->getGrades();
        $gradesCount = count($grades);

        if ($gradesCount === 0) {
            return 'N/A';
        }

        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $total = 0;

        foreach ($grades as $grade) {
            if (array_key_exists($grade, $gradeValues)) {
                $total += $gradeValues[$grade];
            }
        }

        $avg = $total / $gradesCount;

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
        return view('livewire.dealer.home.glba-stats');
    }

    private function violationAudits()
    {
        return GlbaViolationAudit::query()->where('store_id', $this->store->id);
    }

    private function getGrades(): array
    {
        if ($this->cachedGrades !== null) {
            return $this->cachedGrades;
        }

        $this->cachedGrades = tenant_cache_remember(
            'glba_grades_'.$this->store->id,
            now()->addHour(),
            function () {
                $grades = GlbaViolationAudit::query()
                    ->where('store_id', $this->store->id)
                    ->whereNotNull('grade')
                    ->where('grade', '!=', 'N/A')
                    ->pluck('grade')
                    ->toArray();

                $convertedGrade = $this->convertRatingToGrade();
                if ($convertedGrade !== null) {
                    $grades[] = $convertedGrade;
                }

                return $grades;
            }
        );

        return $this->cachedGrades;
    }

    private function convertRatingToGrade(): ?string
    {
        $avg = FinanceAudit::query()
            ->where('store_id', $this->store->id)
            ->whereNotNull('rating')
            ->where('rating', '!=', 'N/A')
            ->avg('rating');

        if ($avg === null) {
            return null;
        }

        return match (true) {
            $avg >= 90 && $avg <= 100 => 'A',
            $avg >= 80 && $avg <= 89 => 'B',
            $avg >= 70 && $avg <= 79 => 'C',
            $avg >= 60 && $avg <= 69 => 'D',
            default => 'F',
        };
    }
}
