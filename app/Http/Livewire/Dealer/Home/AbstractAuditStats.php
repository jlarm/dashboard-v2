<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\Dealer\Store;
use App\Traits\HasAuditStats;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;

abstract class AbstractAuditStats extends Component
{
    use HasAuditStats;

    public Store $store;
    private ?array $cachedGrades = null;

    abstract protected function violationAuditQuery(): Builder;

    abstract protected function auditQuery(): Builder;

    abstract protected function viewName(): string;

    final public function mount(): void
    {
        $this->store = $this->store ?? Store::first();
    }

    final public function rating(): string
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
            $avg >= 2.5 && $avg < 3.5 => 'B',
            $avg >= 1.5 && $avg < 2.5 => 'C',
            $avg >= 0.5 && $avg < 1.5 => 'D',
            $avg >= 0 && $avg < 0.5 => 'F',
            default => 'N/A',
        };
    }

    final public function render(): View
    {
        return view($this->viewName());
    }

    protected function violationAudits(): Builder
    {
        return $this->violationAuditQuery()->where('store_id', $this->store->id);
    }

    private function getGrades(): array
    {
        if ($this->cachedGrades !== null) {
            return $this->cachedGrades;
        }

        $grades = $this->violationAuditQuery()
            ->where('store_id', $this->store->id)
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->pluck('grade')
            ->toArray();

        $convertedGrade = $this->convertRatingToGrade();
        if ($convertedGrade !== null) {
            $grades[] = $convertedGrade;
        }

        $this->cachedGrades = $grades;

        return $this->cachedGrades;
    }

    private function convertRatingToGrade(): ?string
    {
        $avg = $this->auditQuery()
            ->where('store_id', $this->store->id)
            ->whereNotNull('rating')
            ->where('rating', '!=', 'N/A')
            ->avg('rating');

        if ($avg === null) {
            return null;
        }

        return match (true) {
            $avg >= 90 && $avg <= 100 => 'A',
            $avg >= 80 && $avg < 90 => 'B',
            $avg >= 70 && $avg < 80 => 'C',
            $avg >= 60 && $avg < 70 => 'D',
            default => 'F',
        };
    }
}
