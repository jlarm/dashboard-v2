<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\CriticalVulnerabilitiesData;
use App\Domain\Tenant\Scans\Data\ScanDashboardData;
use App\Domain\Tenant\Scans\Queries\GetScanDashboard;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetCriticalVulnerabilities
{
    public function __construct(
        private readonly GetScanDashboard $getScanDashboard,
    ) {}

    /**
     * Returns null when the store has no Cyrisma instance configured —
     * the dashboard then hides the card entirely. When the Cyrisma API
     * is reachable but errors, returns a degraded zero-state so the card
     * still renders rather than blowing up the page.
     */
    public function handleForStore(Store $store, ?CarbonImmutable $now = null): ?CriticalVulnerabilitiesData
    {
        $store->loadMissing('cyrisma');

        if (! $store->hasCyrismaInstanceId()) {
            return null;
        }

        return $this->buildForStore($store, $now ?? CarbonImmutable::now());
    }

    /**
     * Aggregate critical-vulnerability counts across the scoped stores. Returns
     * null when none of them have a Cyrisma instance configured. Critical
     * counts are summed; days-since-last-scan uses the most recent scan
     * across the stores (i.e. the smallest day count).
     *
     * @param  Collection<int, Store>|iterable<int, Store>  $stores
     */
    public function handleForStores(iterable $stores, ?CarbonImmutable $now = null): ?CriticalVulnerabilitiesData
    {
        $now ??= CarbonImmutable::now();
        $eligible = collect($stores)->filter(static function (Store $store): bool {
            $store->loadMissing('cyrisma');

            return $store->hasCyrismaInstanceId();
        });

        if ($eligible->isEmpty()) {
            return null;
        }

        $totalCritical = 0;
        $minDays = null;

        foreach ($eligible as $store) {
            $row = $this->buildForStore($store, $now);
            $totalCritical += $row->critical_count;

            if ($row->days_since_last_scan !== null) {
                $minDays = $minDays === null
                    ? $row->days_since_last_scan
                    : min($minDays, $row->days_since_last_scan);
            }
        }

        return new CriticalVulnerabilitiesData(
            critical_count: $totalCritical,
            days_since_last_scan: $minDays,
        );
    }

    private function buildForStore(Store $store, CarbonImmutable $now): CriticalVulnerabilitiesData
    {
        try {
            $dashboard = $this->getScanDashboard->handle($store);
        } catch (Throwable $e) {
            Log::warning('Critical vulnerabilities: failed to load Cyrisma dashboard', [
                'store_id' => $store->id,
                'message' => $e->getMessage(),
            ]);

            return new CriticalVulnerabilitiesData(
                critical_count: 0,
                days_since_last_scan: null,
            );
        }

        return new CriticalVulnerabilitiesData(
            critical_count: $dashboard->issueCounts->critical ?? 0,
            days_since_last_scan: $this->daysSinceLastScan($dashboard, $now),
        );
    }

    private function daysSinceLastScan(ScanDashboardData $dashboard, CarbonImmutable $now): ?int
    {
        if ($dashboard->lastScanDate === null || $dashboard->lastScanDate === '') {
            return null;
        }

        try {
            $parsed = Date::parse($dashboard->lastScanDate);
        } catch (Throwable) {
            return null;
        }

        return max(0, (int) $parsed->diffInDays($now, true));
    }
}
