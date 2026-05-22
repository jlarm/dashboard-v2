<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\OpenPortData;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

class GetOpenPortsList
{
    public const string ASSET_TYPE_INTERNAL = 'internal';
    public const string ASSET_TYPE_EXTERNAL_IP = 'external_ip';

    public const array ALLOWED_ASSET_TYPES = [
        self::ASSET_TYPE_INTERNAL,
        self::ASSET_TYPE_EXTERNAL_IP,
    ];

    public function __construct(private readonly CyrismaService $cyrisma) {}

    /**
     * @return array{items: list<array<string, mixed>>, available_asset_types: list<string>}
     */
    public function handle(Store $store, ?string $assetType): array
    {
        $service = $this->cyrisma->forStore($store);

        $portsByType = collect(self::ALLOWED_ASSET_TYPES)
            ->mapWithKeys(static fn (string $type): array => [
                $type => $service->getOpenPortsByAssetType($type),
            ])
            ->all();

        $availableAssetTypes = array_values(
            collect($portsByType)
                ->filter(static fn (array $ports): bool => count($ports) > 0)
                ->keys()
                ->all(),
        );

        $selectedPorts = $assetType !== null && $assetType !== ''
            ? ($portsByType[$assetType] ?? [])
            : $service->getOpenPortsByAssetType('');

        $items = array_values(
            collect($selectedPorts)
                ->map(static fn (array $port): array => OpenPortData::fromPayload($port)->toArray())
                ->all(),
        );

        return [
            'items' => $items,
            'available_asset_types' => $availableAssetTypes,
        ];
    }
}
