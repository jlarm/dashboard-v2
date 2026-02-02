<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class OverallRiskDashboard extends Component
{
    public array $riskData = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $this->riskData = $this->cyrisma->getOverallDashboard() ?? [];
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
        } elseif ($currentScore > $previousScore) {
            return 'declined';
        }

        return 'stable';
    }
}
