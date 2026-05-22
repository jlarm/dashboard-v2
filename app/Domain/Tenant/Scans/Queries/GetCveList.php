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
     * @return array{items: list<array<string, mixed>>, available_asset_types: list<string>}
     */
    public function handle(Store $store, ?string $assetType): array
    {
        $service = $this->cyrisma->forStore($store);

        $vulnsByType = collect(self::ALLOWED_ASSET_TYPES)
            ->mapWithKeys(static fn (string $type): array => [
                $type => $service->getVulnerabilitiesByAssetType($type)['vulnerabilities'] ?? [],
            ])
            ->all();

        $availableAssetTypes = array_values(
            collect($vulnsByType)
                ->filter(static fn (array $vulns): bool => count($vulns) > 0)
                ->keys()
                ->all(),
        );

        $selectedVulns = $assetType !== null && $assetType !== ''
            ? ($vulnsByType[$assetType] ?? [])
            : array_merge(...array_values($vulnsByType));

        $items = array_values(
            collect((array) $selectedVulns)
                ->sortByDesc(static fn (array $item): array => [
                    self::riskRank((string) ($item['cve_risk'] ?? '')),
                    (float) ($item['cve_score'] ?? 0),
                ])
                ->values()
                ->map(static fn (array $item): array => CveItemData::fromPayload($item)->toArray())
                ->all(),
        );

        return [
            'items' => $items,
            'available_asset_types' => $availableAssetTypes,
        ];
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
