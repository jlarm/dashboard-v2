<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class CalculateVendorPillar
{
    private const int STALE_AFTER_MONTHS = 12;

    private const float STALE_CONTRIBUTION = 0.5;

    public function handle(Store $store, ?CarbonImmutable $now = null): PillarScoreData
    {
        $now ??= CarbonImmutable::now();
        $staleCutoff = $now->subMonths(self::STALE_AFTER_MONTHS);

        /** @var Collection<int, Vendor> $vendors */
        $vendors = Vendor::query()
            ->where('store_id', $store->id)
            ->with('latestForm')
            ->get();

        if ($vendors->isEmpty()) {
            return PillarScoreData::notApplicable(
                key: 'vendor',
                label: 'Vendor Risk',
                reason: 'No vendors are assigned to this store.',
            );
        }

        $fresh = 0;
        $stale = 0;
        $outstanding = 0;
        $effective = 0.0;

        foreach ($vendors as $vendor) {
            $form = $vendor->latestForm;

            if (! $form instanceof VendorForm || ! $this->isCompleted($form)) {
                $outstanding++;

                continue;
            }

            $signedAt = CarbonImmutable::parse($form->updated_at);

            if ($signedAt->lt($staleCutoff)) {
                $stale++;
                $effective += self::STALE_CONTRIBUTION;

                continue;
            }

            $fresh++;
            $effective += 1.0;
        }

        $score = ($effective / $vendors->count()) * 100.0;

        return new PillarScoreData(
            key: 'vendor',
            label: 'Vendor Risk',
            applicable: true,
            score: round($score, 1),
            weight: 0.0,
            breakdown: [
                'total' => $vendors->count(),
                'fresh_completed' => $fresh,
                'stale_completed' => $stale,
                'outstanding' => $outstanding,
            ],
        );
    }

    private function isCompleted(VendorForm $form): bool
    {
        return $form->signature !== null || $form->document_path !== null;
    }
}
