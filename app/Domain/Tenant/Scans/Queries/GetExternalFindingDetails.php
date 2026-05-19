<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ExternalIpFindingData;
use App\Domain\Tenant\Scans\Support\ExternalFindingNormalizer;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

class GetExternalFindingDetails
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store, string $assetIp, string $findingName): ?ExternalIpFindingData
    {
        $service = $this->cyrisma->forStore($store);
        $payload = $service->getExternalIpScanData();

        if ($payload === null || ! is_array($payload['assets'] ?? null)) {
            return null;
        }

        $asset = collect($payload['assets'])
            ->first(static fn (mixed $candidate): bool => is_array($candidate)
                && ($candidate['ipAddress'] ?? null) === $assetIp);

        if (! is_array($asset)) {
            return null;
        }

        $details = $service->getWebApplicationScanFindingsForAsset($asset, $findingName);

        if ($details === []) {
            return null;
        }

        $first = is_array($details[0] ?? null) ? $details[0] : [];

        return ExternalFindingNormalizer::fromPayload($first);
    }
}
