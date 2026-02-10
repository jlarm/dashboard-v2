<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

trait HasGrade
{
    private const GRADE_CACHE_TTL = 300;

    public function getOshaGradeAttribute(): ?string
    {
        return Cache::remember(
            $this->getGradeCacheKey('osha'),
            self::GRADE_CACHE_TTL,
            fn () => $this->oshaViolationAudits()
                ->whereNotNull('grade')
                ->latest()
                ->first()
                ->grade ?? '-'
        );
    }

    public function getGlbaGradeAttribute(): ?string
    {
        return Cache::remember(
            $this->getGradeCacheKey('glba'),
            self::GRADE_CACHE_TTL,
            fn () => $this->GlbaViolationAudits()
                ->whereNotNull('grade')
                ->latest()
                ->first()
                ->grade ?? '-'
        );
    }

    public function getBodyShopGradeAttribute(): ?string
    {
        return Cache::remember(
            $this->getGradeCacheKey('body_shop'),
            self::GRADE_CACHE_TTL,
            fn () => $this->BodyShopViolationAudits()
                ->whereNotNull('grade')
                ->latest()
                ->first()
                ->grade ?? null
        );
    }

    public function clearGradeCache(?string $type = null): void
    {
        $types = $type ? [$type] : ['osha', 'glba', 'body_shop', 'deal_jacket', 'overall'];

        foreach ($types as $gradeType) {
            Cache::forget($this->getGradeCacheKey($gradeType));
        }
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
        $total = array_reduce(Arr::flatten($grades), fn ($carry, $rating): float|int => $carry + $gradeValues[$rating], 0);

        if ($gradesCount === 0) {
            return 'N/A';
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

    private function getGradeCacheKey(string $type): string
    {
        $tenantId = tenant('id') ?? 'no-tenant';

        return "store_{$this->id}_{$type}_grade_{$tenantId}";
    }

    private function convertRatingToGrade($avg): ?string
    {
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
