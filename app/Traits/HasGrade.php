<?php

namespace App\Traits;

use App\Models\Dealer\Audit\OshaAudit;

trait HasGrade
{
    private function convertRatingToGrade($avg)
    {
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

    private function grades($old, $new): array
    {
        $grades = is_array($new) ? $new : [$new]; // Ensure $new is an array

        if (!empty($old)) {
            $oldGrade = $this->convertRatingToGrade(array_sum($old) / count($old));
            if ($oldGrade !== null) {
                $grades[] = $oldGrade;
            }
        }

        return array_merge(...array_map(fn($grade) => (array)$grade, $grades)); // Ensure all elements are arrays
    }

    public function rating($old, $new): string
    {
        $gradesCount = count($this->grades($old, $new));
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $total = 0;

        $combinedRatings = array_map([$this, 'convertRatingToGrade'], array_merge($old, $new)); // Convert ratings to grades

        foreach ($combinedRatings as $rating) {
            if (isset($gradeValues[$rating])) { // Check if the grade is valid
                $total += $gradeValues[$rating];
            }
        }

        if ($gradesCount == 0) {
            return 'N/A';
        } else {
            $avg = $total / count($this->grades($old, $new));
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
}
