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

        return $this;
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

    public function getOpenPorts(?string $cveId = null)
    {
        $scanId = $this->getStoreReport('scans/vulnerability');
        $scanId = $scanId['vulnerability_scans'][0]['scan_id'] ?? null;
        $scanId = $this->getStoreReport('scans/vulnerability/'.$scanId);

        return $scanId['assets'][0]['openPorts'];
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
