<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class CveRiskChart extends Component
{
    public array $chartData = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $this->loadChartData();
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.cve-risk-chart');
    }

    protected function loadChartData(): void
    {
        $scanData = $this->cyrisma->getVulnerabilityScans();
        $scans = $scanData['vulnerability_scans'] ?? [];

        // If no scans, create empty chart
        if (empty($scans)) {
            $this->chartData = [
                'categories' => [],
                'series' => [
                    ['name' => 'Critical', 'data' => []],
                    ['name' => 'High', 'data' => []],
                    ['name' => 'Medium', 'data' => []],
                    ['name' => 'Low', 'data' => []],
                ],
            ];

            return;
        }

        // Get the 5 most recent scans sorted by date (oldest to newest)
        $sortedScans = collect($scans)
            ->sortByDesc('scan_finished')
            ->take(5)
            ->sortBy('scan_finished')
            ->values();

        // Extract data for each severity level
        $categories = [];
        $criticalData = [];
        $highData = [];
        $mediumData = [];
        $lowData = [];

        foreach ($sortedScans as $index => $scan) {
            // Use scan_finished as the date
            $scanDate = $scan['scan_finished'] ?? $scan['scan_started'] ?? null;

            if ($scanDate) {
                $timestamp = strtotime((string) $scanDate);
                $categories[] = date('M Y', $timestamp);
            } else {
                // Use scan name or index if no date
                $categories[] = $scan['scan_name'] ?? ('Scan '.($index + 1));
            }

            $criticalData[] = (int) ($scan['critical_vulnerabilities'] ?? 0);
            $highData[] = (int) ($scan['high_vulnerabilities'] ?? 0);
            $mediumData[] = (int) ($scan['medium_vulnerabilities'] ?? 0);
            $lowData[] = (int) ($scan['low_vulnerabilities'] ?? 0);
        }

        $this->chartData = [
            'categories' => $categories,
            'series' => [
                [
                    'name' => 'Critical',
                    'data' => $criticalData,
                ],
                [
                    'name' => 'High',
                    'data' => $highData,
                ],
                [
                    'name' => 'Medium',
                    'data' => $mediumData,
                ],
                [
                    'name' => 'Low',
                    'data' => $lowData,
                ],
            ],
        ];
    }
}
