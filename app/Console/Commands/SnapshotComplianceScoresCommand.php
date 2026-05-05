<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Domain\Tenant\Compliance\Queries\CalculateComplianceScore;
use App\Domain\Tenant\Compliance\Queries\CalculateExpiredTraining;
use App\Domain\Tenant\Compliance\Queries\CalculateOverdueRemediations;
use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Store;
use App\Models\TenantComplianceSnapshot;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Override;

class SnapshotComplianceScoresCommand extends Command
{
    #[Override]
    protected $signature = 'compliance:snapshot-scores {--tenants=* : The tenant(s) to run for. Default all.}';

    #[Override]
    protected $description = 'Compute and persist a daily compliance score snapshot per store.';

    public function handle(
        CalculateComplianceScore $calculator,
        CalculateOverdueRemediations $overdueQuery,
        CalculateExpiredTraining $trainingQuery,
    ): void {
        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $t): bool => is_string($t) && $t !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function () use ($calculator, $overdueQuery, $trainingQuery): void {
            $this->snapshotForCurrentTenant($calculator, $overdueQuery, $trainingQuery);
        });
    }

    private function snapshotForCurrentTenant(
        CalculateComplianceScore $calculator,
        CalculateOverdueRemediations $overdueQuery,
        CalculateExpiredTraining $trainingQuery,
    ): void {
        $today = CarbonImmutable::now();

        Store::query()->each(function (Store $store) use ($calculator, $overdueQuery, $trainingQuery, $today): void {
            $score = $calculator->handle($store, $today);
            $overdue = $overdueQuery->handle($store, $today);
            $expiredTraining = $trainingQuery->handleForStore($store);

            $weights = collect($score->pillars)
                ->mapWithKeys(static fn (PillarScoreData $pillar): array => [$pillar->key => round($pillar->weight, 4)])
                ->all();

            ComplianceScoreSnapshot::query()->updateOrCreate(
                [
                    'store_id' => $store->id,
                    'scored_on' => $today->toDateString(),
                ],
                [
                    'score' => round($score->score, 2),
                    'pillars' => array_map(
                        static fn (PillarScoreData $pillar): array => $pillar->toArray(),
                        $score->pillars,
                    ),
                    'weights' => $weights,
                    'overdue_count' => $overdue['count'],
                    'overdue_high_severity_count' => $overdue['high_severity_count'],
                    'expired_training_count' => $expiredTraining['count'],
                    'expiring_soon_training_count' => $expiredTraining['expiring_soon_count'],
                ],
            );
        });

        $tenantTotals = $trainingQuery->handleForTenant();

        TenantComplianceSnapshot::query()->updateOrCreate(
            ['scored_on' => $today->toDateString()],
            [
                'expired_training_count' => $tenantTotals['count'],
                'expiring_soon_training_count' => $tenantTotals['expiring_soon_count'],
            ],
        );
    }
}
