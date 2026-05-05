<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Domain\Tenant\Scans\Data\ScanDashboardData;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Throwable;

class CalculateCyberPillar
{
    private const CRITICAL_PENALTY = 8.0;

    private const HIGH_PENALTY = 3.0;

    private const MEDIUM_PENALTY = 1.0;

    private const ISSUE_PENALTY_CAP = 60.0;

    private const FRESH_SCAN_DAYS = 30;

    private const STALENESS_PENALTY_PER_WEEK = 7.0;

    private const STALENESS_PENALTY_CAP = 30.0;

    private const NO_SCAN_DATA_SCORE = 40.0;

    private const DEGRADED_SCORE = 50.0;

    public function __construct(
        private readonly GetScanDashboard $getScanDashboard,
    ) {}

    public function handle(Store $store, ?CarbonImmutable $now = null): PillarScoreData
    {
        $store->loadMissing('cyrisma');

        if (! $store->hasCyrismaShortName()) {
            return PillarScoreData::notApplicable(
                key: 'cyber',
                label: 'Cyber Posture',
                reason: 'This store does not use IT scans.',
            );
        }

        $now ??= CarbonImmutable::now();

        try {
            $dashboard = $this->getScanDashboard->handle($store);
        } catch (Throwable $e) {
            Log::warning('Cyber pillar: failed to load Cyrisma dashboard', [
                'store_id' => $store->id,
                'message' => $e->getMessage(),
            ]);

            return new PillarScoreData(
                key: 'cyber',
                label: 'Cyber Posture',
                applicable: true,
                score: self::DEGRADED_SCORE,
                weight: 0.0,
                breakdown: ['state' => 'degraded', 'reason' => 'Scan data temporarily unavailable.'],
            );
        }

        if (! $dashboard->hasScanData) {
            return new PillarScoreData(
                key: 'cyber',
                label: 'Cyber Posture',
                applicable: true,
                score: self::NO_SCAN_DATA_SCORE,
                weight: 0.0,
                breakdown: $this->breakdown($dashboard, null, null, null, 'No scan results yet.'),
            );
        }

        $issuePenalty = $this->issuePenalty($dashboard);
        $stalenessPenalty = $this->stalenessPenalty($dashboard, $now);
        $score = max(0.0, 100.0 - $issuePenalty - $stalenessPenalty);

        return new PillarScoreData(
            key: 'cyber',
            label: 'Cyber Posture',
            applicable: true,
            score: round($score, 1),
            weight: 0.0,
            breakdown: $this->breakdown(
                $dashboard,
                $issuePenalty,
                $stalenessPenalty,
                $this->daysSinceLastScan($dashboard, $now),
                null,
            ),
        );
    }

    private function issuePenalty(ScanDashboardData $dashboard): float
    {
        $counts = $dashboard->issueCounts;

        $penalty = ($counts->critical ?? 0) * self::CRITICAL_PENALTY
            + ($counts->high ?? 0) * self::HIGH_PENALTY
            + ($counts->medium ?? 0) * self::MEDIUM_PENALTY;

        return min(self::ISSUE_PENALTY_CAP, (float) $penalty);
    }

    private function stalenessPenalty(ScanDashboardData $dashboard, CarbonImmutable $now): float
    {
        $daysSince = $this->daysSinceLastScan($dashboard, $now);

        if ($daysSince === null || $daysSince <= self::FRESH_SCAN_DAYS) {
            return 0.0;
        }

        $weeksOver = ($daysSince - self::FRESH_SCAN_DAYS) / 7.0;

        return min(self::STALENESS_PENALTY_CAP, $weeksOver * self::STALENESS_PENALTY_PER_WEEK);
    }

    private function daysSinceLastScan(ScanDashboardData $dashboard, CarbonImmutable $now): ?int
    {
        if ($dashboard->lastScanDate === null || $dashboard->lastScanDate === '') {
            return null;
        }

        try {
            $parsed = Date::parse($dashboard->lastScanDate);
        } catch (Throwable) {
            return null;
        }

        return max(0, (int) $parsed->diffInDays($now, true));
    }

    /**
     * @return array<string, mixed>
     */
    private function breakdown(
        ScanDashboardData $dashboard,
        ?float $issuePenalty,
        ?float $stalenessPenalty,
        ?int $daysSinceLastScan,
        ?string $note,
    ): array {
        return [
            'critical' => $dashboard->issueCounts->critical,
            'high' => $dashboard->issueCounts->high,
            'medium' => $dashboard->issueCounts->medium,
            'low' => $dashboard->issueCounts->low,
            'last_scan_date' => $dashboard->lastScanDate,
            'days_since_last_scan' => $daysSinceLastScan,
            'issue_penalty' => $issuePenalty === null ? null : round($issuePenalty, 1),
            'staleness_penalty' => $stalenessPenalty === null ? null : round($stalenessPenalty, 1),
            'note' => $note,
        ];
    }
}
