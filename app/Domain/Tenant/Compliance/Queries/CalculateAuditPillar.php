<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CalculateAuditPillar
{
    private const array GRADE_TO_SCORE = ['A' => 100, 'B' => 85, 'C' => 70, 'D' => 55, 'F' => 40];

    private const int STALE_AFTER_MONTHS = 12;

    private const float STALE_PILLAR_FALLBACK = 50.0;

    private const float REMEDIATION_PENALTY_PER_SEVERITY = 4.0;

    private const float REMEDIATION_PENALTY_CAP = 30.0;

    /**
     * @var array<string, array{label: string, class: class-string<ViolationAudit&Model>}>
     */
    private const array AUDIT_TYPES = [
        'osha' => ['label' => 'OSHA', 'class' => OshaViolationAudit::class],
        'body_shop' => ['label' => 'Body Shop', 'class' => BodyShopViolationAudit::class],
        'glba' => ['label' => 'GLBA', 'class' => GlbaViolationAudit::class],
    ];

    public function handle(Store $store, ?CarbonImmutable $now = null): PillarScoreData
    {
        $now ??= CarbonImmutable::now();
        $staleCutoff = $now->subMonths(self::STALE_AFTER_MONTHS);

        $perType = [];
        $appliedScores = [];

        foreach (self::AUDIT_TYPES as $key => $config) {
            $latest = $this->latestAudit($config['class'], $store->id);

            if (! $latest instanceof Model) {
                $perType[$key] = [
                    'label' => $config['label'],
                    'has_audit' => false,
                    'stale' => true,
                    'score' => self::STALE_PILLAR_FALLBACK,
                ];
                $appliedScores[] = self::STALE_PILLAR_FALLBACK;

                continue;
            }

            $auditDate = $latest->date instanceof DateTimeInterface ? CarbonImmutable::parse($latest->date) : null;
            $stale = ! $auditDate instanceof CarbonImmutable || $auditDate->lt($staleCutoff);

            $gradeScore = self::GRADE_TO_SCORE[mb_strtoupper((string) $latest->grade)] ?? self::STALE_PILLAR_FALLBACK;
            $penalty = $this->outstandingRemediationPenalty($latest);
            $score = max(0.0, $gradeScore - $penalty);

            if ($stale) {
                $score = min($score, self::STALE_PILLAR_FALLBACK);
            }

            $perType[$key] = [
                'label' => $config['label'],
                'has_audit' => true,
                'stale' => $stale,
                'grade' => $latest->grade,
                'audit_date' => $auditDate?->format('Y-m-d'),
                'outstanding_remediations' => $this->outstandingRemediationCount($latest),
                'score' => round($score, 1),
            ];
            $appliedScores[] = $score;
        }

        $score = array_sum($appliedScores) / count($appliedScores);

        return new PillarScoreData(
            key: 'audit',
            label: 'Audit Health',
            applicable: true,
            score: round($score, 1),
            weight: 0.0,
            breakdown: ['types' => $perType],
        );
    }

    /**
     * @param  class-string<ViolationAudit&Model>  $modelClass
     * @return (ViolationAudit&Model)|null
     */
    private function latestAudit(string $modelClass, int $storeId): ?Model
    {
        /** @var Builder<ViolationAudit&Model> $query */
        $query = $modelClass::query();

        return $query
            ->where('store_id', $storeId)
            ->whereNotNull('grade')
            ->whereNotNull('date')
            ->withCount([
                'violations as violation_count',
                'violations as remediation_count' => function (Builder $q): void {
                    $q->whereHas('remediation', fn (Builder $r) => $r->where('completed', true));
                },
            ])
            ->orderByDesc('date')
            ->first();
    }

    private function outstandingRemediationPenalty(Model $audit): float
    {
        $rows = Violation::query()
            ->where('violationable_id', $audit->getKey())
            ->where('violationable_type', $audit->getMorphClass())
            ->whereDoesntHave('remediation', fn (Builder $r) => $r->where('completed', true))
            ->get(['severity']);

        $total = 0.0;
        foreach ($rows as $row) {
            $severity = max(1, (int) ($row->severity ?? 1));
            $total += $severity * self::REMEDIATION_PENALTY_PER_SEVERITY;
        }

        return min($total, self::REMEDIATION_PENALTY_CAP);
    }

    private function outstandingRemediationCount(Model $audit): int
    {
        $violationCount = (int) ($audit->violation_count ?? 0);
        $remediationCount = (int) ($audit->remediation_count ?? 0);

        return max(0, $violationCount - $remediationCount);
    }
}
