<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\AuditTrackerRowData;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GetAuditTracker
{
    private const int STALE_AFTER_MONTHS = 12;

    /**
     * Letter grade → numeric value used for delta math. Higher is better.
     *
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
     * @var array<int, array{key:string, label:string, class:class-string<Model>}>
     */
    private const array VIOLATION_AUDIT_TYPES = [
        ['key' => 'osha', 'label' => 'OSHA', 'class' => OshaViolationAudit::class],
        ['key' => 'body_shop', 'label' => 'Body Shop', 'class' => BodyShopViolationAudit::class],
        ['key' => 'glba', 'label' => 'GLBA', 'class' => GlbaViolationAudit::class],
    ];

    private const array DEAL_JACKET_TYPE = ['key' => 'deal_jacket', 'label' => 'Deal Jacket'];

    /**
     * One row per audit type. Each row reflects the most recent completed
     * audit across the scoped stores, with a delta vs the immediately prior
     * completed audit and a derived passing/action-required/overdue status.
     *
     * @param  list<int>  $storeIds
     * @return list<AuditTrackerRowData>
     */
    public function handleForStores(array $storeIds, ?CarbonImmutable $now = null): array
    {
        $now ??= CarbonImmutable::now();
        $rows = [];

        foreach (self::VIOLATION_AUDIT_TYPES as $type) {
            $rows[] = $this->buildViolationAuditRow($type, $storeIds, $now);
        }

        $rows[] = $this->buildDealJacketRow($storeIds, $now);

        return $rows;
    }

    /**
     * @param  array{key:string, label:string, class:class-string<Model>}  $type
     * @param  list<int>  $storeIds
     */
    private function buildViolationAuditRow(array $type, array $storeIds, CarbonImmutable $now): AuditTrackerRowData
    {
        if ($storeIds === []) {
            return $this->emptyRow($type['key'], $type['label']);
        }

        [$latest, $previous] = $this->latestAndPrevious($type['class'], $storeIds);

        if ($latest === null) {
            return $this->emptyRow($type['key'], $type['label']);
        }

        $auditDate = $latest->date instanceof DateTimeInterface
            ? CarbonImmutable::instance($latest->date)
            : null;

        $grade = $this->normalizeGrade((string) $latest->grade);
        $deltaLabel = $this->deltaLabel($grade, $previous?->grade);
        $status = $this->resolveStatus($grade, $auditDate, $now);
        $hasReport = ! empty($latest->pdf_path);

        return new AuditTrackerRowData(
            type_key: $type['key'],
            type_label: $type['label'],
            last_audit_date: $auditDate?->format('M j, Y'),
            grade: $grade,
            delta_label: $deltaLabel,
            status: $status,
            has_report: $hasReport,
        );
    }

    /**
     * Deal Jacket audits don't carry a grade column — we read from
     * IndividualAudit.rating (a 0–100 score) and convert to a letter grade
     * with the same thresholds Store::calculateGrade uses elsewhere.
     *
     * @param  list<int>  $storeIds
     */
    private function buildDealJacketRow(array $storeIds, CarbonImmutable $now): AuditTrackerRowData
    {
        $key = self::DEAL_JACKET_TYPE['key'];
        $label = self::DEAL_JACKET_TYPE['label'];

        if ($storeIds === []) {
            return $this->emptyRow($key, $label);
        }

        $audits = IndividualAudit::query()
            ->whereIn('store_id', $storeIds)
            ->whereNotNull('rating')
            ->whereNotNull('audit_date')
            ->latest('audit_date')
            ->orderByDesc('id')
            ->limit(2)
            ->get(['id', 'audit_date', 'rating']);

        $latest = $audits->get(0);
        $previous = $audits->get(1);

        if ($latest === null) {
            return $this->emptyRow($key, $label);
        }

        $auditDate = $latest->audit_date instanceof DateTimeInterface
            ? CarbonImmutable::instance($latest->audit_date)
            : null;

        $grade = $this->ratingToGrade((float) $latest->rating);
        $previousGrade = $previous !== null ? $this->ratingToGrade((float) $previous->rating) : null;
        $deltaLabel = $this->deltaLabel($grade, $previousGrade);
        $status = $this->resolveStatus($grade, $auditDate, $now);
        $hasReport = DealJacketGroup::query()
            ->whereIn('store_id', $storeIds)
            ->where('completed', true)
            ->exists();

        return new AuditTrackerRowData(
            type_key: $key,
            type_label: $label,
            last_audit_date: $auditDate?->format('M j, Y'),
            grade: $grade,
            delta_label: $deltaLabel,
            status: $status,
            has_report: $hasReport,
        );
    }

    private function emptyRow(string $key, string $label): AuditTrackerRowData
    {
        return new AuditTrackerRowData(
            type_key: $key,
            type_label: $label,
            last_audit_date: null,
            grade: null,
            delta_label: null,
            status: 'overdue',
            has_report: false,
        );
    }

    private function ratingToGrade(float $rating): ?string
    {
        return match (true) {
            $rating >= 90 => 'A',
            $rating >= 80 => 'B',
            $rating >= 70 => 'C',
            $rating >= 60 => 'D',
            $rating >= 0 => 'F',
            default => null,
        };
    }

    /**
     * @param  class-string<Model>  $auditClass
     * @param  list<int>  $storeIds
     * @return array{0:?Model,1:?Model}
     */
    private function latestAndPrevious(string $auditClass, array $storeIds): array
    {
        /** @var Builder<Model> $query */
        $query = $auditClass::query();

        $audits = $query
            ->whereIn('store_id', $storeIds)
            ->whereNotNull('grade')
            ->where('grade', '!=', 'N/A')
            ->whereNotNull('date')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(2)
            ->get(['id', 'date', 'grade', 'pdf_path']);

        return [$audits->get(0), $audits->get(1)];
    }

    private function normalizeGrade(string $grade): ?string
    {
        $upper = mb_strtoupper(mb_trim($grade));

        return array_key_exists($upper, self::GRADE_VALUES) ? $upper : null;
    }

    private function deltaLabel(?string $current, ?string $previous): ?string
    {
        if ($current === null || $previous === null) {
            return null;
        }

        $previous = mb_strtoupper(mb_trim($previous));

        if (! array_key_exists($previous, self::GRADE_VALUES)) {
            return null;
        }

        $delta = self::GRADE_VALUES[$current] - self::GRADE_VALUES[$previous];

        if ($delta === 0) {
            return 'No change';
        }

        $sign = $delta > 0 ? '+' : '−';

        return $sign.abs($delta).' vs prior';
    }

    /**
     * @return 'passing'|'action_required'|'overdue'
     */
    private function resolveStatus(?string $grade, ?CarbonImmutable $auditDate, CarbonImmutable $now): string
    {
        if (! $auditDate instanceof CarbonImmutable || $auditDate->lt($now->subMonths(self::STALE_AFTER_MONTHS))) {
            return 'overdue';
        }

        return match ($grade) {
            'A', 'B' => 'passing',
            'C' => 'action_required',
            default => 'overdue',
        };
    }
}
