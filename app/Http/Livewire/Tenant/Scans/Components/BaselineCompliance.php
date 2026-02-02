<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class BaselineCompliance extends Component
{
    public string $currentGrade = '';
    public string $previousGrade = '';
    public array $systems = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $data = $this->cyrisma->getBaselineDashboard();

        $this->currentGrade = $data['current_grade'] ?? '-';
        $this->previousGrade = $data['previous_grade'] ?? '-';
        $this->systems = array_slice($data['lowest_pass_targets_domain'] ?? [], 0, 10);
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.baseline-compliance');
    }

    public function getGradeTrend(): string
    {
        $gradeMap = [
            'A' => 1, 'A-' => 2,
            'B+' => 3, 'B' => 4, 'B-' => 5,
            'C+' => 6, 'C' => 7, 'C-' => 8,
            'D+' => 9, 'D' => 10, 'D-' => 11,
            'F' => 12, 'N/A' => 99,
        ];

        $currentScore = $gradeMap[$this->currentGrade] ?? 99;
        $previousScore = $gradeMap[$this->previousGrade] ?? 99;

        if ($currentScore < $previousScore) {
            return 'improved';
        } elseif ($currentScore > $previousScore) {
            return 'declined';
        }

        return 'stable';
    }

    public function getPassRateColor(float $passRate): string
    {
        if ($passRate >= 90) {
            return 'green';
        }

        if ($passRate >= 70) {
            return 'yellow';
        }

        if ($passRate >= 50) {
            return 'orange';
        }

        return 'red';
    }
}
