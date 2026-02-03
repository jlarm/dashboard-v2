<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class OverallRiskDashboard extends Component
{
    public array $riskData = [];
    public ?string $lastScanDate = null;
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $this->riskData = $this->cyrisma->getOverallDashboard() ?? [];
        $this->lastScanDate = $this->getLastScanDate();
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.overall-risk-dashboard');
    }

    public function getGradeTrend(string $current, string $previous): string
    {
        $gradeMap = [
            'A' => 1, 'A-' => 2,
            'B+' => 3, 'B' => 4, 'B-' => 5,
            'C+' => 6, 'C' => 7, 'C-' => 8,
            'D+' => 9, 'D' => 10, 'D-' => 11,
            'F' => 12,
        ];

        $currentScore = $gradeMap[$current] ?? 99;
        $previousScore = $gradeMap[$previous] ?? 99;

        if ($currentScore < $previousScore) {
            return 'improved';
        }
        if ($currentScore > $previousScore) {
            return 'declined';
        }

        return 'stable';
    }

    protected function getLastScanDate(): ?string
    {
        $scans = $this->cyrisma->getVulnerabilityScans();

        if (! $scans || empty($scans['vulnerability_scans'])) {
            return null;
        }

        $latestScan = collect($scans['vulnerability_scans'])
            ->sortByDesc('scan_finished')
            ->first();

        if (! $latestScan || empty($latestScan['scan_finished'])) {
            return null;
        }

        return Carbon::parse($latestScan['scan_finished'])->format('M j, Y');
    }
}
