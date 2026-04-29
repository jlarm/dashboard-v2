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
     * @return list<array{port_number: string, port_description: ?string, risk_level: string, machine_count: int}>
     */
    public function handle(Store $store, ?string $assetType): array
    {
        $service = $this->cyrisma->forStore($store);
        $resolvedAssetType = $assetType ?? '';

        $ports = $service->getOpenPortsByAssetType($resolvedAssetType);

        return collect($ports)
            ->map(static fn (array $port): array => OpenPortData::fromPayload($port)->toArray())
            ->values()
            ->all();
    }
}
