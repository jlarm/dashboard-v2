<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\LocationGradeRowData;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;

class GetLocationGrades
{
    /**
     * @var array<string, int>
     */
    private const array GRADE_VALUES = [
        'A' => 4,
        'B' => 3,
        'C' => 2,
        'D' => 1,
        'F' => 0,
    ];

    /**
     * One row per scoped store with each audit-type letter grade and a
     * derived overall grade (average of the available audit grades, using
     * the same thresholds as Store::getOverallGradeAttribute).
     *
     * Grades are loaded via correlated subqueries — a single Store query
     * yields every per-store grade we need, so the dashboard does not have
     * to fan out N×audit-type queries when rendering an overview.
     *
     * @param  list<int>  $storeIds
     * @return list<LocationGradeRowData>
     */
    public function handleForStores(array $storeIds): array
    {
        if ($storeIds === []) {
            return [];
        }

        $stores = Store::query()
            ->whereIn('id', $storeIds)
            ->orderBy('name')
            ->addSelect(['osha_grade' => $this->latestGradeSubquery(OshaViolationAudit::class)])
            ->addSelect(['glba_grade' => $this->latestGradeSubquery(GlbaViolationAudit::class)])
            ->addSelect(['body_shop_grade' => $this->latestGradeSubquery(BodyShopViolationAudit::class)])
            ->addSelect([
                'deal_jacket_rating' => IndividualAudit::query()
                    ->select('rating')
                    ->whereColumn('store_id', 'stores.id')
                    ->whereNotNull('rating')
                    ->whereNotNull('audit_date')
                    ->orderByDesc('audit_date')
                    ->orderByDesc('id')
                    ->limit(1),
            ])
            ->get(['id', 'name']);

        return $stores->map(function (Store $store): LocationGradeRowData {
            $osha = $this->normalizeGrade($store->getAttribute('osha_grade'));
            $glba = $this->normalizeGrade($store->getAttribute('glba_grade'));
            $bodyShop = $this->normalizeGrade($store->getAttribute('body_shop_grade'));
            $dealJacket = $this->ratingToGrade($store->getAttribute('deal_jacket_rating'));

            return new LocationGradeRowData(
                store_id: (int) $store->id,
                store_name: (string) $store->name,
                overall: $this->overallGrade([$osha, $glba, $bodyShop, $dealJacket]),
                deal_jacket: $dealJacket,
                osha: $osha,
                glba: $glba,
                body_shop: $bodyShop,
            );
        })->values()->all();
    }

    /**
     * @param  class-string  $auditClass
     */
    private function latestGradeSubquery(string $auditClass): \Illuminate\Database\Eloquent\Builder
    {
        return $auditClass::query()
            ->select('grade')
            ->whereColumn('store_id', 'stores.id')
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->whereNotNull('date')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(1);
    }

    private function normalizeGrade(mixed $grade): ?string
    {
        if ($grade === null || $grade === '') {
            return null;
        }

        $upper = mb_strtoupper(mb_trim((string) $grade));

        return array_key_exists($upper, self::GRADE_VALUES) ? $upper : null;
    }

    private function ratingToGrade(mixed $rating): ?string
    {
        if ($rating === null) {
            return null;
        }

        return match (true) {
            (float) $rating >= 90 => 'A',
            (float) $rating >= 80 => 'B',
            (float) $rating >= 70 => 'C',
            (float) $rating >= 60 => 'D',
            (float) $rating >= 0 => 'F',
            default => null,
        };
    }

    /**
     * @param  list<?string>  $grades
     */
    private function overallGrade(array $grades): ?string
    {
        $valid = array_values(array_filter(
            $grades,
            fn (?string $grade): bool => $grade !== null && array_key_exists($grade, self::GRADE_VALUES),
        ));

        if ($valid === []) {
            return null;
        }

        $avg = array_sum(array_map(fn (string $grade): int => self::GRADE_VALUES[$grade], $valid)) / count($valid);

        return match (true) {
            $avg >= 3.5 => 'A',
            $avg >= 2.5 => 'B',
            $avg >= 1.5 => 'C',
            $avg >= 0.5 => 'D',
            default => 'F',
        };
    }
}
