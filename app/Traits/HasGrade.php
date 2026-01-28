<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Arr;

trait HasGrade
{
    public function getOshaGradeAttribute(): ?string
    {
        return $this->oshaViolationAudits()
            ->whereNotNull('grade')
            ->latest()
            ->first()
            ->grade ?? '-';
    }

    public function getGlbaGradeAttribute(): ?string
    {
        return $this->GlbaViolationAudits()
            ->whereNotNull('grade')
            ->latest()
            ->first()
            ->grade ?? '-';
    }

    public function getBodyShopGradeAttribute(): ?string
    {
        return $this->BodyShopViolationAudits()
            ->whereNotNull('grade')
            ->latest()
            ->first()
            ->grade ?? null;
    }

    public function rating($old, $new): string
    {
        if (empty($old) && empty($new)) {
            return 'N/A';
        }

        $old = Arr::flatten($old);
        $new = Arr::flatten($new);

        $grades = $this->grades($old, $new);
        $gradesCount = count($grades);
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $total = array_reduce(Arr::flatten($grades), fn ($carry, $rating) => $carry + $gradeValues[$rating], 0);

        if ($gradesCount === 0) {
            return 'N/A';
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

    private function convertRatingToGrade($avg)
    {
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

    private function grades($old, $new): array
    {
        $grades = [$new];

        if (! empty($old)) {
            $oldGrade = $this->convertRatingToGrade(array_sum($old) / count($old));
            if ($oldGrade !== null) {
                $grades[] = $oldGrade;
            }
        }

        return $grades;
    }
}
