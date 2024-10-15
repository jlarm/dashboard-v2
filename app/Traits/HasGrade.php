<?php

namespace App\Traits;

use App\Models\Dealer\Audit\OshaAudit;
use Illuminate\Support\Arr;

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
        $grades[] = $new;

        if (!empty($old)) {
            $oldGrade = $this->convertRatingToGrade(array_sum($old) / count($old));
            if ($oldGrade !== null) {
                $grades[] = $oldGrade;
            }
        }

        return $grades;
    }

    public function rating($old, $new): string
    {
        if (empty($old) && empty($new)) {
            return 'N/A';
        }

        $gradesCount = count($this->grades($old, $new));
        $gradeValues = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $total = 0;

        
        foreach (Arr::flatten($this->grades($old, $new)) as $rating) {
            $total += $gradeValues[$rating];
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
