<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Dealer\Store;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CyrismaService
{
    protected ?string $baseUrl;
    protected ?string $apiKey;
    protected ?string $apiSecret;
    protected ?string $accessToken = null;
    protected ?string $shortName = null;
    protected ?Store $store = null;

    public function __construct()
    {
        $this->baseUrl = config('services.cyrisma.base_url');
        $this->apiKey = config('services.cyrisma.api_key');
        $this->apiSecret = config('services.cyrisma.api_secret');
    }

    public function isConfigured(): bool
    {
        return ! in_array($this->baseUrl, [null, '', '0'], true)
            && (! in_array($this->apiKey, [null, '', '0'], true))
            && (! in_array($this->apiSecret, [null, '', '0'], true));
    }

    public function forStore(Store $store): self
    {
        $this->store = $store;
        $this->shortName = $store->cyrisma->short_name ?? null;

        return $this;
    }

    public function hasShortName(): bool
    {
        return $this->store && $this->store->hasCyrismaShortName();
    }

    public function hasInternalScans(): bool
    {
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'])) {
            return false;
        }

        return collect((array) $vulnerabilityScans['vulnerability_scans'])
            ->contains(function (array $scan): bool {
                $scanType = $scan['scan_type'] ?? null;
                $scanTypeName = mb_strtolower($scan['scan_type_name'] ?? '');

                // Internal Authenticated (5) or Internal Unauthenticated (10)
                return $scanType === 5 || $scanType === 10
                    || str_contains($scanTypeName, 'internal');
            });
    }

    public function clearCache(): void
    {
        if (! $this->store instanceof Store) {
            return;
        }

        // Increment the cache version to invalidate all cached data for this store
        $versionKey = "cyrisma_cache_version_{$this->store->id}";
        Cache::increment($versionKey);
    }

    public function authenticate(): ?string
    {
        if (! $this->isConfigured()) {
            Log::warning('Cyrisma API credentials are not configured');

            return null;
        }

        $cacheKey = 'cyrisma_access_token';

        // Try to get token from cache (expires in 9 minutes, token lasts 10)
        $token = Cache::get($cacheKey);

        if ($token) {
            $this->accessToken = $token;

            return $token;
        }

        try {
            $response = Http::asForm()->post("{$this->baseUrl}/partner/login/", [
                'grant_type' => 'password',
                'username' => $this->apiKey,
                'password' => $this->apiSecret,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->accessToken = $data['access_token'];

                Cache::put($cacheKey, $this->accessToken, now()->addMinutes(9));

                return $this->accessToken;
            }

            Log::error('Cyrisma authentication failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('Cyrisma authentication error', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function authenticateInstance(?string $instanceId = null): bool
    {
        if (! $this->ensureAuthenticated()) {
            return false;
        }

        $url = $instanceId
            ? "{$this->baseUrl}/partner/instances/login/{$instanceId}"
            : "{$this->baseUrl}/partner/instances/login/";

        try {
            $response = $this->authorizedRequest()->post($url);

            if ($response->successful()) {
                $data = $response->json();

                if (! empty($data['success_token_inserts'])) {
                    Log::info('Cyrisma instance authenticated', [
                        'instance_id' => $instanceId,
                        'success_count' => count($data['success_token_inserts']),
                    ]);

                    return true;
                }
            }

            Log::error('Cyrisma instance authentication error', [
                'message' => $response->status(),
                'instance_id' => $instanceId,
            ]);

            return false;
        } catch (Exception $e) {
            Log::error('Cyrisma instance authentication error', [
                'message' => $e->getMessage(),
                'instance_id' => $instanceId,
            ]);

            return false;
        }
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getAllInstances(): ?array
    {
        if (! $this->ensureAuthenticated()) {
            return null;
        }

        try {
            $response = $this->authorizedRequest()
                ->get("{$this->baseUrl}/partner/instances/info/");

            return $response->successful() ? $response->json() : null;
        } catch (Exception $e) {
            Log::error('Failed to get Cyrisma instances', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getInstance(string $instanceId): ?array
    {
        if (! $this->ensureAuthenticated()) {
            return null;
        }

        try {
            $response = $this->authorizedRequest()
                ->get("{$this->baseUrl}/partner/instances/info/{$instanceId}");

            if ($response->successful()) {
                $data = $response->json();

                return $data[0] ?? null;
            }

            return null;
        } catch (Exception $e) {
            Log::error('Failed to get Cyrisma instance', [
                'message' => $e->getMessage(),
                'instance_id' => $instanceId,
            ]);

            return null;
        }
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function findInstanceByShortName(string $shortName): ?array
    {
        $instances = $this->getAllInstances();

        if (! $instances) {
            return null;
        }

        return collect($instances)->firstWhere('short_name', $shortName);
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getDataScans(): ?array
    {
        return $this->getStoreReport('scans/data');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getVulnerabilityScans(): ?array
    {
        return $this->getStoreReport('scans/vulnerability');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getBaselineScans(): ?array
    {
        return $this->getStoreReport('scans/baseline');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getOverallDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/overall');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getDataDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/data');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getVulnerabilityDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/vulnerability');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getBaselineDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/baseline');
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getCveDetails(?string $cveId = null): ?array
    {
        return $this->getStoreReport(
            'dashboards/vulnerability/cve',
            $cveId ? ['cve_id' => $cveId] : []
        );
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getVulnerabilitiesByAssetType(?string $assetType = null): ?array
    {
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'])) {
            return ['vulnerabilities' => []];
        }

        $scans = collect((array) $vulnerabilityScans['vulnerability_scans']);

        // Filter scans based on asset type using scan_type numeric values from API docs:
        // - scan type 5 = Internal Authenticated
        // - scan type 9 = External IP
        // - scan type 10 = Internal Unauthenticated
        // - scan type 11 = External Web Application
        if ($assetType) {
            $scans = $scans->filter(function (array $scan) use ($assetType): bool {
                $scanType = $scan['scan_type'] ?? null;
                $scanTypeName = mb_strtolower($scan['scan_type_name'] ?? '');

                return match ($assetType) {
                    'internal' => in_array($scanType, [5, 10], true) || str_contains($scanTypeName, 'internal'),
                    'external_ip' => $scanType === 9 || (str_contains($scanTypeName, 'external') && str_contains($scanTypeName, 'ip') && ! str_contains($scanTypeName, 'web')),
                    'external_web' => $scanType === 11 || (str_contains($scanTypeName, 'external') && str_contains($scanTypeName, 'web')),
                    default => true,
                };
            });
        }

        if ($scans->isEmpty()) {
            return ['vulnerabilities' => []];
        }

        // Get the most recent scan of this type
        $latestScan = $scans->sortByDesc('scan_finished')->first();

        if (! $latestScan) {
            return ['vulnerabilities' => []];
        }

        // Get detailed scan results
        $scanDetails = $this->getStoreReport('scans/vulnerability/'.$latestScan['scan_id']);

        if (! $scanDetails || ! isset($scanDetails['assets'])) {
            return ['vulnerabilities' => []];
        }

        // Determine what data to include based on scan type:
        // - Internal Authenticated (5), Internal Unauthenticated (10), External IP (9): vulnerabilities + openPorts
        // - External Web Application (11): flaws only
        $isWebAppScan = $assetType === 'external_web';
        $vulnerabilities = [];

        foreach ($scanDetails['assets'] as $asset) {
            if ($isWebAppScan) {
                // Web application scans only have flaws
                if (isset($asset['flaws']) && is_array($asset['flaws'])) {
                    foreach ($asset['flaws'] as $flaw) {
                        $vulnerabilities[] = [
                            'id' => $flaw['alertRef'] ?? 'Flaw-'.$flaw['alertId'],
                            'title' => $flaw['alertName'] ?? 'Unknown Flaw',
                            'cve_score' => $this->getPortRiskScore($flaw['riskLevel'] ?? 'Medium'),
                            'cve_risk' => $flaw['riskLevel'] ?? 'Medium',
                            'published_date' => isset($latestScan['scan_finished']) ? date('Y-m-d', strtotime((string) $latestScan['scan_finished'])) : '-',
                            'affected_targets' => $flaw['target'] ?? 'Unknown',
                            'num_affected_targets' => $flaw['alertCount'] ?? 1,
                            'type' => 'flaw',
                        ];
                    }
                }
            } else {
                // IP-based scans have vulnerabilities and openPorts
                if (isset($asset['vulnerabilities']) && is_array($asset['vulnerabilities'])) {
                    foreach ($asset['vulnerabilities'] as $vuln) {
                        $vulnerabilities[] = [
                            'id' => $vuln['cve'] ?? 'Unknown',
                            'title' => $vuln['title'] ?? 'Unknown Vulnerability',
                            'cve_score' => $vuln['score'] ?? 0,
                            'cve_risk' => $vuln['riskLevel'] ?? 'Unknown',
                            'published_date' => isset($vuln['firstSeen']) ? date('Y-m-d', strtotime((string) $vuln['firstSeen'])) : '-',
                            'affected_targets' => $asset['name'] ?? $asset['ipAddress'] ?? 'Unknown',
                            'num_affected_targets' => 1,
                            'type' => 'cve',
                        ];
                    }
                }

                if (isset($asset['openPorts']) && is_array($asset['openPorts'])) {
                    foreach ($asset['openPorts'] as $port) {
                        $portNumber = $port['portNumber'];
                        $targetName = $port['targetName'] ?? $port['targetIp'] ?? 'Unknown';

                        // Group by port number - check if we already have this port
                        $existingKey = array_search($portNumber, array_column($vulnerabilities, 'port_number'));

                        if ($existingKey !== false && ($vulnerabilities[$existingKey]['type'] ?? '') === 'open_port') {
                            // Add target to existing port entry
                            $vulnerabilities[$existingKey]['num_affected_targets']++;
                            $existingTargets = $vulnerabilities[$existingKey]['affected_targets'];
                            if (! str_contains((string) $existingTargets, (string) $targetName)) {
                                $vulnerabilities[$existingKey]['affected_targets'] .= ', '.$targetName;
                            }
                        } else {
                            $vulnerabilities[] = [
                                'id' => 'Open Port '.$portNumber,
                                'port_number' => $portNumber,
                                'title' => $port['portDescription'] ?? 'Open Port '.$portNumber,
                                'cve_score' => $this->getPortRiskScore($port['riskLevel'] ?? 'Low'),
                                'cve_risk' => $port['riskLevel'] ?? 'Low',
                                'published_date' => isset($latestScan['scan_finished']) ? date('Y-m-d', strtotime((string) $latestScan['scan_finished'])) : '-',
                                'affected_targets' => $targetName,
                                'num_affected_targets' => 1,
                                'type' => 'open_port',
                                'message' => 'There are open/listening ports on the target. Port '.$portNumber.'.',
                            ];
                        }
                    }
                }
            }
        }

        return ['vulnerabilities' => $vulnerabilities];
    }

    /**
     * @return array<array-key, mixed>|null
     */
    public function getOpenPorts(?string $cveId = null): ?array
    {
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'][0]['scan_id'])) {
            return null;
        }

        $scanId = $vulnerabilityScans['vulnerability_scans'][0]['scan_id'];
        $scanDetails = $this->getStoreReport('scans/vulnerability/'.$scanId);

        if (! $scanDetails || ! isset($scanDetails['assets'][0]['openPorts'])) {
            return null;
        }

        return $scanDetails['assets'][0]['openPorts'];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getOpenPortsByAssetType(string $assetType = ''): array
    {
        $assetTypes = $assetType !== ''
            ? [$assetType]
            : ['internal', 'external_ip'];

        $aggregatedPorts = [];

        foreach ($assetTypes as $type) {
            $apiAssetType = match ($type) {
                'internal' => 'internal',
                'external_ip' => 'external',
                default => null,
            };

            if ($apiAssetType === null) {
                continue;
            }

            $assets = $this->getStoreReport('vulnerability/assets', ['assetType' => $apiAssetType]);
            if (! $assets) {
                continue;
            }

            foreach ($assets as $asset) {
                $scanType = $asset['scanType'] ?? '';
                $assetId = $asset['assetId'] ?? null;
                $assetIp = $asset['assetIp'] ?? $asset['ip'] ?? '';

                $ports = $this->getAssetOpenPorts($scanType, $assetId, $assetIp);

                foreach ($ports as $port) {
                    $portNumber = $port['portNumber'];
                    $existingIndex = array_search($portNumber, array_column($aggregatedPorts, 'portNumber'));

                    if ($existingIndex !== false) {
                        $aggregatedPorts[$existingIndex]['machineCount']++;
                    } else {
                        $aggregatedPorts[] = [
                            'portNumber' => $portNumber,
                            'portDescription' => $port['portDescription'],
                            'riskLevel' => $port['riskLevel'],
                            'machineCount' => 1,
                        ];
                    }
                }
            }
        }

        return $aggregatedPorts;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getExternalIpScanData(): ?array
    {
        // Try the vulnerability dashboard first - it might have aggregated external IP data
        $this->getStoreReport('dashboards/vulnerability');

        // Get list of all vulnerability scans
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'])) {
            return null;
        }

        // Look specifically for External scan types (type 9 = External IP, type 11 = External Web)
        $externalScans = collect((array) $vulnerabilityScans['vulnerability_scans'])
            ->filter(function (array $scan): bool {
                $scanTypeName = mb_strtolower($scan['scan_type_name'] ?? '');
                $scanType = $scan['scan_type'] ?? '';

                // Match external scans by name or type
                return str_contains($scanTypeName, 'external') ||
                       $scanType === 'external_vulnerability' ||
                       $scanType === 9 ||
                       $scanType === '9' ||
                       $scanType === 11 ||
                       $scanType === '11';
            })
            ->sortByDesc('scan_finished');

        if ($externalScans->isEmpty()) {
            return null;
        }

        // Collect ALL assets from ALL external scans, keyed by IP to deduplicate
        $assetsByIp = [];
        $latestScan = null;

        foreach ($externalScans as $scan) {
            // Get detailed scan results from the instance-specific endpoint
            $scanDetails = $this->getStoreReport('scans/vulnerability/'.$scan['scan_id']);

            if ($scanDetails && isset($scanDetails['assets']) && is_array($scanDetails['assets'])) {
                foreach ($scanDetails['assets'] as $asset) {
                    // Only include assets that have an IP address, deduplicate by IP
                    if (! empty($asset['ipAddress'])) {
                        $ip = $asset['ipAddress'];
                        // Keep the first occurrence (from most recent scan since scans are sorted by date desc)
                        if (! isset($assetsByIp[$ip])) {
                            $assetsByIp[$ip] = $asset;
                        }
                    }
                }

                // Use the most recent scan as the scan_info
                if (! $latestScan) {
                    $latestScan = $scan;
                }
            }
        }

        $allAssets = array_values($assetsByIp);

        if ($allAssets === []) {
            return null;
        }

        return [
            'scan_info' => $latestScan,
            'assets' => $allAssets,
        ];
    }

    /**
     * @param  array<string, mixed>  $asset
     * @return array<int, array<string, mixed>>
     */
    public function getWebApplicationScanFindingsForAsset(array $asset, ?string $findingName = null): array
    {
        $endpointCandidates = [
            'vulnerability/assets/webapp',
            'vulnerability/assets/web',
            'vulnerability/asset/web',
            'vulnerability/assets/web-app',
            'vulnerability/assets/webapplication',
            'vulnerability/assets/web_application',
            'vulnerability/assets/web/findings',
            'vulnerability/assets/webapp/findings',
            'vulnerability/assets/web-application',
            'vulnerability/assets/web-application/findings',
            'vulnerability/assets/web-application-scan-findings',
            'vulnerability/assets/web-application-scan-findings-for-an-asset',
            'vulnerability/assets/web/application',
        ];

        $paramSets = $this->buildWebAssetParamSets($asset);
        foreach ($endpointCandidates as $endpoint) {
            foreach ($paramSets as $params) {
                $response = $this->getStoreReport($endpoint, $params);
                if (! is_array($response)) {
                    continue;
                }

                $findings = $this->extractWebFindingsFromPayload($response);
                if ($findings === []) {
                    continue;
                }

                if ($findingName === null || $findingName === '') {
                    return $findings;
                }

                $matchingFindings = collect($findings)
                    ->filter(function (array $finding) use ($findingName): bool {
                        $name = mb_strtolower(mb_trim((string) ($finding['alertName'] ?? $finding['title'] ?? $finding['name'] ?? $finding['alertRef'] ?? '')));

                        return $name === mb_strtolower(mb_trim($findingName));
                    })
                    ->values()
                    ->all();

                if ($matchingFindings !== []) {
                    return $matchingFindings;
                }
            }
        }

        return [];
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<array-key, mixed>|null
     */
    public function getStoreReport(string $endpoint, array $params = []): ?array
    {
        if (! $this->store || ! $this->store->cyrisma) {
            Log::error('No store context or Cyrisma configuration set for Cyrisma report');

            return null;
        }

        $cacheKey = sprintf(
            'cyrisma_report_%s_v%s_%s_%s',
            $this->store->id,
            $this->getCacheVersion(),
            str_replace('/', '_', $endpoint),
            md5(serialize($params))
        );

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($endpoint, $params) {
            if (! $this->ensureAuthenticated()) {
                return null;
            }

            $this->authenticateInstance($this->store->cyrisma->instance_id);

            $url = "https://{$this->store->cyrisma->instance_url}/app/partner/{$endpoint}";

            try {
                $request = $this->authorizedRequest();

                $response = $request->asForm()->get($url, $params);

                if ($response->successful()) {
                    return $response->json();
                }

                Log::error('Cyrisma API request failed', [
                    'endpoint' => $endpoint,
                    'url' => $url,
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'store_id' => $this->store->id,
                ]);

                return null;
            } catch (Exception $e) {
                Log::error('Failed to get Cyrisma store report', [
                    'message' => $e->getMessage(),
                    'endpoint' => $endpoint,
                    'store_id' => $this->store->id,
                ]);

                return null;
            }
        });
    }

    /**
     * @return array<int, array{portNumber: string, portDescription: string, riskLevel: string}>
     */
    protected function getAssetOpenPorts(string $scanType, ?string $assetId, string $assetIp): array
    {
        $scanTypeLower = mb_strtolower($scanType);

        if (str_contains($scanTypeLower, 'internal authenticated') && $assetId) {
            $result = $this->getStoreReport('vulnerability/assets/authenticated', ['assetId' => $assetId]);
            $data = $result[0] ?? [];

            return collect((array) ($data['openPorts'] ?? []))
                ->map(fn (array $port): array => [
                    'portNumber' => $port['port'],
                    'portDescription' => $port['portName'] ?? '',
                    'riskLevel' => ucfirst($port['severity'] ?? 'Low'),
                ])
                ->all();
        }

        if ((str_contains($scanTypeLower, 'external') && str_contains($scanTypeLower, 'ip')) && $assetIp !== '') {
            $result = $this->getStoreReport('vulnerability/assets/ip', ['assetIp' => $assetIp]);
            $data = is_array($result) && isset($result[0]) ? $result[0] : ($result ?? []);

            return collect((array) ($data['OpenPorts'] ?? $data['openPorts'] ?? []))
                ->map(fn (array $port): array => [
                    'portNumber' => $port['PortNumber'] ?? $port['portNumber'] ?? '',
                    'portDescription' => $port['PortDescription'] ?? $port['portDescription'] ?? '',
                    'riskLevel' => ucfirst((string) ($port['RiskLevel'] ?? $port['riskLevel'] ?? 'Low')),
                ])
                ->all();
        }

        return [];
    }

    /**
     * @param  array<string, mixed>  $asset
     * @return array<int, array<string, string>>
     */
    protected function buildWebAssetParamSets(array $asset): array
    {
        $assetId = mb_trim((string) ($asset['assetId'] ?? $asset['id'] ?? ''));
        $assetName = mb_trim((string) ($asset['name'] ?? ''));
        $assetUrl = mb_trim((string) ($asset['assetUrl'] ?? $asset['url'] ?? ''));
        $assetIp = mb_trim((string) ($asset['ipAddress'] ?? $asset['assetIp'] ?? $asset['ip'] ?? ''));

        $paramSets = [];

        if ($assetId !== '') {
            $paramSets[] = ['assetId' => $assetId];
            $paramSets[] = ['assetID' => $assetId];
            $paramSets[] = ['asset_id' => $assetId];
        }

        foreach (array_filter([$assetUrl, $assetName, $assetIp], fn (string $value): bool => $value !== '') as $value) {
            $paramSets[] = ['assetUrl' => $value];
            $paramSets[] = ['assetURL' => $value];
            $paramSets[] = ['assetName' => $value];
            $paramSets[] = ['asset' => $value];
            $paramSets[] = ['assetIp' => $value];
            $paramSets[] = ['url' => $value];
            $paramSets[] = ['target' => $value];
            $paramSets[] = ['website' => $value];
        }

        if ($paramSets === []) {
            return [];
        }

        $uniqueParamSets = [];
        foreach ($paramSets as $paramSet) {
            $paramKey = array_key_first($paramSet);
            $paramValue = $paramSet[$paramKey];
            $uniqueParamSets["{$paramKey}:{$paramValue}"] = $paramSet;
        }

        return array_values($uniqueParamSets);
    }

    /**
     * @param  array<array-key, mixed>  $payload
     * @return array<int, array<string, mixed>>
     */
    protected function extractWebFindingsFromPayload(array $payload): array
    {
        $findingCollections = [];

        if (array_is_list($payload)) {
            $findingCollections[] = $payload;
        }

        foreach (['flaws', 'findings', 'alerts', 'results', 'data'] as $key) {
            if (isset($payload[$key]) && is_array($payload[$key])) {
                $findingCollections[] = $payload[$key];
            }
        }

        foreach ($payload as $item) {
            if (! is_array($item)) {
                continue;
            }

            foreach (['flaws', 'findings', 'alerts', 'results'] as $key) {
                if (isset($item[$key]) && is_array($item[$key])) {
                    $findingCollections[] = $item[$key];
                }
            }
        }

        return collect($findingCollections)
            ->flatten(1)
            ->filter(fn (mixed $item): bool => is_array($item))
            ->map(fn (mixed $item): array => $item)
            ->filter(fn (array $finding): bool => array_any(['alertName', 'alertRef', 'title', 'name', 'riskLevel', 'severity', 'description', 'alertDesc', 'solution', 'alertSolution', 'instances', 'alertInstances', 'details', 'urls', 'targets', 'referenceURLs'], fn (mixed $key): bool => array_key_exists((string) $key, $finding)))
            ->values()
            ->all();
    }

    protected function getCacheVersion(): int
    {
        if (! $this->store instanceof Store) {
            return 1;
        }

        return (int) Cache::get("cyrisma_cache_version_{$this->store->id}", 1);
    }

    protected function getPortRiskScore(string $riskLevel): float
    {
        return match (mb_strtolower($riskLevel)) {
            'critical' => 9.5,
            'high' => 7.5,
            'medium' => 5.0,
            'low' => 2.5,
            default => 0.0,
        };
    }

    protected function isPublicIp(string $ip): bool
    {
        if ($ip === '' || $ip === '0') {
            return false;
        }

        // Check if it's a valid IP
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        // Check if it's a private IP range
        return (bool) filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    protected function ensureAuthenticated(): bool
    {
        if (! $this->accessToken) {
            return $this->authenticate() !== null;
        }

        return true;
    }

    protected function authorizedRequest(): PendingRequest
    {
        return Http::withHeaders([
            'Authorization' => "access_token {$this->accessToken}",
        ]);
    }
}
