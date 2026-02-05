<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class ExternalIpExposure extends Component
{
    public array $scanInfo = [];
    public array $externalAssets = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $data = $this->cyrisma->getExternalIpScanData();

        if ($data) {
            $this->scanInfo = $data['scan_info'] ?? [];
            $this->externalAssets = $data['assets'] ?? [];
        }
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.external-ip-exposure');
    }

    public function getTotalVulnerabilities(array $asset): int
    {
        if (! isset($asset['vulnerabilities'])) {
            return 0;
        }

        return count($asset['vulnerabilities']);
    }

    public function getVulnerabilityCounts(array $asset): array
    {
        $critical = 0;
        $high = 0;
        $medium = 0;
        $low = 0;

        if (isset($asset['vulnerabilities'])) {
            foreach ($asset['vulnerabilities'] as $vuln) {
                $riskLevel = mb_strtolower($vuln['riskLevel'] ?? '');

                match ($riskLevel) {
                    'critical' => $critical++,
                    'high' => $high++,
                    'medium' => $medium++,
                    'low' => $low++,
                    default => null,
                };
            }
        }

        return compact('critical', 'high', 'medium', 'low');
    }

    public function getRiskColor(int $critical, int $high): string
    {
        if ($critical > 0) {
            return 'red';
        }

        if ($high >= 5) {
            return 'orange';
        }

        if ($high > 0) {
            return 'yellow';
        }

        return 'green';
    }
}
