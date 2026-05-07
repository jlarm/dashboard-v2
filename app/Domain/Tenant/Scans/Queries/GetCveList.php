<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\CveItemData;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

class GetCveList
{
    public const string ASSET_TYPE_INTERNAL = 'internal';
    public const string ASSET_TYPE_EXTERNAL_IP = 'external_ip';
    public const string ASSET_TYPE_EXTERNAL_WEB = 'external_web';

    public const array ALLOWED_ASSET_TYPES = [
        self::ASSET_TYPE_INTERNAL,
        self::ASSET_TYPE_EXTERNAL_IP,
        self::ASSET_TYPE_EXTERNAL_WEB,
    ];

    public function __construct(private readonly CyrismaService $cyrisma) {}

    /**
     * @return list<array{id: string, title: string, risk: string, score: ?float, published_date: ?string, affected_targets: ?string, num_affected_targets: ?int, type: string}>
     */
    public function handle(Store $store, ?string $assetType): array
    {
        $service = $this->cyrisma->forStore($store);

        $assetTypes = $assetType !== null && $assetType !== ''
            ? [$assetType]
            : self::ALLOWED_ASSET_TYPES;

        return collect($assetTypes)
            ->flatMap(static function (string $type) use ($service): array {
                $data = $service->getVulnerabilitiesByAssetType($type);

                return $data['vulnerabilities'] ?? [];
            })
            ->sortByDesc(static fn (array $item): array => [
                self::riskRank((string) ($item['cve_risk'] ?? '')),
                (float) ($item['cve_score'] ?? 0),
            ])
            ->values()
            ->map(static fn (array $item): array => CveItemData::fromPayload($item)->toArray())
            ->all();
    }

    private static function riskRank(string $risk): int
    {
        return match (mb_strtolower($risk)) {
            'critical' => 5,
            'high' => 4,
            'medium' => 3,
            'low' => 2,
            default => 1,
        };
    }
}
