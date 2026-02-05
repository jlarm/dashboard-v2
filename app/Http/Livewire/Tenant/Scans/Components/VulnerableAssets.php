<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class VulnerableAssets extends Component
{
    public array $assets = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $data = $this->cyrisma->getVulnerabilityDashboard();
        $this->assets = $data['top_10_most_sensitive'] ?? [];
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.vulnerable-assets');
    }

    public function getTotalVulnerabilities(array $asset): int
    {
        return ($asset['vuln_count_critical'] ?? 0)
            + ($asset['vuln_count_high'] ?? 0)
            + ($asset['vuln_count_medium'] ?? 0)
            + ($asset['vuln_count_low'] ?? 0);
    }

    public function getRiskColor(int $critical, int $high): string
    {
        if ($critical >= 10) {
            return 'red';
        }

        if ($critical >= 5 || $high >= 20) {
            return 'orange';
        }

        if ($high >= 10) {
            return 'yellow';
        }

        return 'gray';
    }
}
