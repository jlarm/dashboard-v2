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
        return ! empty($this->baseUrl)
            && ! empty($this->apiKey)
            && ! empty($this->apiSecret);
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

    public function findInstanceByShortName(string $shortName): ?array
    {
        $instances = $this->getAllInstances();

        if (! $instances) {
            return null;
        }

        return collect($instances)->firstWhere('short_name', $shortName);
    }

    public function getDataScans(): ?array
    {
        return $this->getStoreReport('scans/data');
    }

    public function getVulnerabilityScans(): ?array
    {
        return $this->getStoreReport('scans/vulnerability');
    }

    public function getBaselineScans(): ?array
    {
        return $this->getStoreReport('scans/baseline');
    }

    public function getOverallDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/overall');
    }

    public function getDataDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/data');
    }

    public function getVulnerabilityDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/vulnerability');
    }

    public function getBaselineDashboard(): ?array
    {
        return $this->getStoreReport('dashboards/baseline');
    }

    public function getCveDetails(?string $cveId = null): ?array
    {
        return $this->getStoreReport(
            'dashboards/vulnerability/cve',
            $cveId ? ['cve_id' => $cveId] : []
        );
    }

    public function getVulnerabilitiesByAssetType(?string $assetType = null): ?array
    {
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'])) {
            return null;
        }

        $scans = collect($vulnerabilityScans['vulnerability_scans']);

        // Filter scans based on asset type
        if ($assetType) {
            $scans = $scans->filter(function ($scan) use ($assetType) {
                $scanTypeName = mb_strtolower($scan['scan_type_name'] ?? '');

                return match ($assetType) {
                    'internal' => str_contains($scanTypeName, 'internal authenticated'),
                    'external_ip' => str_contains($scanTypeName, 'external') && str_contains($scanTypeName, 'ip'),
                    'external_web' => str_contains($scanTypeName, 'external') && str_contains($scanTypeName, 'web'),
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

        // Collect all vulnerabilities and open ports from assets
        $vulnerabilities = [];

        foreach ($scanDetails['assets'] as $asset) {
            // Add CVE vulnerabilities
            if (isset($asset['vulnerabilities']) && is_array($asset['vulnerabilities'])) {
                foreach ($asset['vulnerabilities'] as $vuln) {
                    $vulnerabilities[] = [
                        'id' => $vuln['cve'] ?? 'Unknown',
                        'title' => $vuln['title'] ?? 'Unknown Vulnerability',
                        'cve_score' => $vuln['score'] ?? 0,
                        'cve_risk' => $vuln['riskLevel'] ?? 'Unknown',
                        'published_date' => isset($vuln['firstSeen']) ? date('Y-m-d', strtotime($vuln['firstSeen'])) : '-',
                        'affected_targets' => $asset['name'] ?? $asset['ipAddress'] ?? 'Unknown',
                        'num_affected_targets' => 1,
                    ];
                }
            }

            // Add open ports as vulnerabilities
            if (isset($asset['openPorts']) && is_array($asset['openPorts'])) {
                foreach ($asset['openPorts'] as $port) {
                    $vulnerabilities[] = [
                        'id' => 'Open Port '.$port['portNumber'],
                        'title' => $port['portDescription'] ?? 'Open Port '.$port['portNumber'],
                        'cve_score' => $this->getPortRiskScore($port['riskLevel'] ?? 'Low'),
                        'cve_risk' => $port['riskLevel'] ?? 'Low',
                        'published_date' => isset($latestScan['scan_finished']) ? date('Y-m-d', strtotime($latestScan['scan_finished'])) : '-',
                        'affected_targets' => $port['targetName'] ?? $port['targetIp'] ?? 'Unknown',
                        'num_affected_targets' => 1,
                    ];
                }
            }
        }

        return ['vulnerabilities' => $vulnerabilities];
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

    public function getExternalIpScanData(): ?array
    {
        // Try the vulnerability dashboard first - it might have aggregated external IP data
        $vulnDashboard = $this->getStoreReport('dashboards/vulnerability');

        \Log::info('Vulnerability Dashboard response:', [
            'has_response' => ! is_null($vulnDashboard),
            'response_keys' => $vulnDashboard ? array_keys($vulnDashboard) : [],
            'full_response' => $vulnDashboard,
        ]);

        // Get list of all vulnerability scans
        $vulnerabilityScans = $this->getStoreReport('scans/vulnerability');

        if (! $vulnerabilityScans || ! isset($vulnerabilityScans['vulnerability_scans'])) {
            return null;
        }

        // Look specifically for External scan types (type 9 = External IP, type 11 = External Web)
        $externalScans = collect($vulnerabilityScans['vulnerability_scans'])
            ->filter(function ($scan) {
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

        \Log::info('Found external scans:', [
            'count' => $externalScans->count(),
            'scans' => $externalScans->values()->toArray(),
        ]);

        if ($externalScans->isEmpty()) {
            return null;
        }

        // Collect ALL assets from ALL external scans, keyed by IP to deduplicate
        $assetsByIp = [];
        $latestScan = null;

        foreach ($externalScans as $scan) {
            // Get detailed scan results from the instance-specific endpoint
            $scanDetails = $this->getStoreReport('scans/vulnerability/'.$scan['scan_id']);

            \Log::info('External scan API response:', [
                'scan_id' => $scan['scan_id'],
                'scan_name' => $scan['scan_name'] ?? 'unknown',
                'has_response' => ! is_null($scanDetails),
                'response_keys' => $scanDetails ? array_keys($scanDetails) : [],
                'has_assets_key' => isset($scanDetails['assets']),
                'asset_count' => isset($scanDetails['assets']) ? count($scanDetails['assets']) : 0,
                'full_response' => $scanDetails,
            ]);

            if ($scanDetails && isset($scanDetails['assets']) && is_array($scanDetails['assets'])) {
                foreach ($scanDetails['assets'] as $asset) {
                    \Log::info('Processing asset:', [
                        'asset_id' => $asset['id'] ?? 'unknown',
                        'asset_name' => $asset['name'] ?? 'unknown',
                        'ip_address' => $asset['ipAddress'] ?? 'missing',
                        'has_vulnerabilities' => isset($asset['vulnerabilities']),
                        'vuln_count' => isset($asset['vulnerabilities']) ? count($asset['vulnerabilities']) : 0,
                    ]);

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

        \Log::info('Final external IP results:', [
            'total_assets_found' => count($allAssets),
            'latest_scan' => $latestScan,
        ]);

        if (empty($allAssets)) {
            return null;
        }

        return [
            'scan_info' => $latestScan,
            'assets' => $allAssets,
        ];
    }

    protected function isPublicIp(string $ip): bool
    {
        if (empty($ip)) {
            return false;
        }

        // Check if it's a valid IP
        if (! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        // Check if it's a private IP range
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
            return true;
        }

        return false;
    }

    public function getStoreReport(string $endpoint, array $params = []): ?array
    {
        if (! $this->store || ! $this->store->cyrisma) {
            Log::error('No store context or Cyrisma configuration set for Cyrisma report');

            return null;
        }

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
