<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\ComplianceScoreData;
use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;

class CalculateComplianceScore
{
    /**
     * Raw weights per pillar before applicability is evaluated. These represent
     * the relative importance of each pillar; the orchestrator re-normalizes
     * across whichever pillars actually apply to the store.
     *
     * @var array<string, float>
     */
    public const array RAW_WEIGHTS = [
        'audit' => 0.35,
        'training' => 0.25,
        'cyber' => 0.15,
        'vendor' => 0.15,
        'docs' => 0.10,
    ];

    public function __construct(
        private readonly CalculateAuditPillar $auditPillar,
        private readonly CalculateTrainingPillar $trainingPillar,
        private readonly CalculateCyberPillar $cyberPillar,
        private readonly CalculateVendorPillar $vendorPillar,
        private readonly CalculateDocsPillar $docsPillar,
    ) {}

    public function handle(Store $store, ?CarbonImmutable $now = null): ComplianceScoreData
    {
        $now ??= CarbonImmutable::now();

        $pillars = [
            $this->auditPillar->handle($store, $now),
            $this->trainingPillar->handle($store),
            $this->cyberPillar->handle($store, $now),
            $this->vendorPillar->handle($store, $now),
            $this->docsPillar->handle($store, $now),
        ];

        $weighted = $this->applyWeights($pillars);

        $overall = array_reduce(
            $weighted,
            static fn (float $carry, PillarScoreData $pillar): float => $carry + $pillar->contribution(),
            0.0,
        );

        return new ComplianceScoreData(
            storeId: (int) $store->id,
            score: round($overall, 1),
            pillars: $weighted,
            computedAt: $now,
        );
    }

    /**
     * Drop inapplicable pillars, then renormalize the remaining weights so they
     * sum to 1.0. A store missing every applicable pillar gets a zero weighting
     * vector and a score of 0; the controller surfaces "no data" in that case.
     *
     * @param  list<PillarScoreData>  $pillars
     * @return list<PillarScoreData>
     */
    private function applyWeights(array $pillars): array
    {
        $applicableTotal = 0.0;
        foreach ($pillars as $pillar) {
            if ($pillar->applicable) {
                $applicableTotal += self::RAW_WEIGHTS[$pillar->key] ?? 0.0;
            }
        }

        return array_map(
            static function (PillarScoreData $pillar) use ($applicableTotal): PillarScoreData {
                if (! $pillar->applicable || $applicableTotal <= 0.0) {
                    return $pillar->withWeight(0.0);
                }

                $raw = self::RAW_WEIGHTS[$pillar->key] ?? 0.0;

                return $pillar->withWeight($raw / $applicableTotal);
            },
            $pillars,
        );
    }
}
