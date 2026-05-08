<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

class CalculateDocsPillar
{
    private const int STALE_AFTER_MONTHS = 12;

    private const float STALE_CONTRIBUTION = 0.5;

    /**
     * @var array<string, array{label: string, class: class-string<Model>, signature_field: string}>
     */
    private const array MANUAL_TYPES = [
        'isp' => ['label' => 'ISP', 'class' => Isp::class, 'signature_field' => 'signature'],
        'osha' => ['label' => 'OSHA', 'class' => Osha::class, 'signature_field' => 'signature'],
        'red_flag' => ['label' => 'Red Flag', 'class' => RedFlag::class, 'signature_field' => 'signature'],
        'cms' => ['label' => 'CMS', 'class' => CmsManual::class, 'signature_field' => 'acknowledgement_signature'],
    ];

    public function handle(Store $store, ?CarbonImmutable $now = null): PillarScoreData
    {
        $now ??= CarbonImmutable::now();
        $staleCutoff = $now->subMonths(self::STALE_AFTER_MONTHS);

        $perType = [];
        $effective = 0.0;

        foreach (self::MANUAL_TYPES as $key => $config) {
            $latest = $this->latestManual($config['class'], $store->id);

            if (! $latest instanceof Model || $latest->getAttribute($config['signature_field']) === null) {
                $perType[$key] = [
                    'label' => $config['label'],
                    'state' => 'missing',
                    'signed_at' => null,
                ];

                continue;
            }

            $signedAt = CarbonImmutable::parse($latest->getAttribute('updated_at'));
            $stale = $signedAt->lt($staleCutoff);

            $perType[$key] = [
                'label' => $config['label'],
                'state' => $stale ? 'stale' : 'fresh',
                'signed_at' => $signedAt->toDateString(),
            ];

            $effective += $stale ? self::STALE_CONTRIBUTION : 1.0;
        }

        $score = ($effective / count(self::MANUAL_TYPES)) * 100.0;

        return new PillarScoreData(
            key: 'docs',
            label: 'Document Currency',
            applicable: true,
            score: round($score, 1),
            weight: 0.0,
            breakdown: ['types' => $perType],
        );
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    private function latestManual(string $modelClass, int $storeId): ?Model
    {
        return $modelClass::query()
            ->where('store_id', $storeId)
            ->latest('updated_at')
            ->first();
    }
}
