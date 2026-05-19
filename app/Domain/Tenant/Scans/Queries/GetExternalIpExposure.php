<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Queries;

use App\Domain\Tenant\Scans\Data\ExternalIpAssetData;
use App\Domain\Tenant\Scans\Data\ExternalIpExposureData;
use App\Domain\Tenant\Scans\Support\ExternalFindingNormalizer;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;

class GetExternalIpExposure
{
    public function __construct(private readonly CyrismaService $cyrisma) {}

    public function handle(Store $store): ExternalIpExposureData
    {
        $service = $this->cyrisma->forStore($store);
        $payload = $service->getExternalIpScanData();

        if ($payload === null) {
            return new ExternalIpExposureData(lastScanFinished: null, assets: []);
        }

        $rawAssets = is_array($payload['assets'] ?? null) ? $payload['assets'] : [];
        $scanInfo = is_array($payload['scan_info'] ?? null) ? $payload['scan_info'] : [];

        $assets = collect($rawAssets)
            ->map(static fn (array $asset): array => self::buildAsset($asset))
            ->values()
            ->all();

        return new ExternalIpExposureData(
            lastScanFinished: isset($scanInfo['scan_finished']) && is_string($scanInfo['scan_finished'])
                ? $scanInfo['scan_finished']
                : null,
            assets: $assets,
        );
    }

    /**
     * @param  array<string, mixed>  $asset
     * @return array<string, mixed>
     */
    private static function buildAsset(array $asset): array
    {
        $findings = ExternalFindingNormalizer::findingsFor($asset);
        $openPorts = self::normalizeOpenPorts($asset['openPorts'] ?? []);

        $counts = [
            'critical' => 0,
            'high' => 0,
            'medium' => 0,
            'low' => 0,
        ];

        foreach ($findings as $finding) {
            $level = mb_strtolower($finding['risk_level']);

            if (array_key_exists($level, $counts)) {
                $counts[$level]++;
            }
        }

        return new ExternalIpAssetData(
            name: (string) ($asset['name'] ?? $asset['ipAddress'] ?? 'Unknown Asset'),
            ipAddress: isset($asset['ipAddress']) && is_string($asset['ipAddress']) && $asset['ipAddress'] !== ''
                ? $asset['ipAddress']
                : null,
            openPorts: $openPorts,
            findings: $findings,
            criticalCount: $counts['critical'],
            highCount: $counts['high'],
            mediumCount: $counts['medium'],
            lowCount: $counts['low'],
        )->toArray();
    }

    /**
     * @return list<array{port_number: string, port_description: ?string, risk_level: string}>
     */
    private static function normalizeOpenPorts(mixed $rawPorts): array
    {
        if (! is_array($rawPorts)) {
            return [];
        }

        return collect($rawPorts)
            ->filter(static fn (mixed $port): bool => is_array($port))
            ->map(static fn (array $port): array => [
                'port_number' => (string) ($port['portNumber'] ?? '-'),
                'port_description' => isset($port['portDescription']) && $port['portDescription'] !== ''
                    ? (string) $port['portDescription']
                    : null,
                'risk_level' => (string) ($port['riskLevel'] ?? 'Unknown'),
            ])
            ->values()
            ->all();
    }
}
