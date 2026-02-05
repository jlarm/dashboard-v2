<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class DataExposure extends Component
{
    public string $currentGrade = '';
    public string $previousGrade = '';
    public array $topCategories = [];
    public array $mostSensitiveEndpoints = [];
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $this->cyrisma = $cyrisma;
        $data = $this->cyrisma->getDataDashboard();

        $this->currentGrade = $data['current_grade'] ?? '-';
        $this->previousGrade = $data['previous_grade'] ?? '-';
        $this->topCategories = $data['top_5_categories'] ?? [];
        $this->mostSensitiveEndpoints = array_slice($data['top_10_most_sensitive'] ?? [], 0, 5);
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.data-exposure');
    }

    public function getGradeTrend(): string
    {
        $gradeMap = [
            'A' => 1, 'A-' => 2,
            'B+' => 3, 'B' => 4, 'B-' => 5,
            'C+' => 6, 'C' => 7, 'C-' => 8,
            'D+' => 9, 'D' => 10, 'D-' => 11,
            'F' => 12,
        ];

        $currentScore = $gradeMap[$this->currentGrade] ?? 99;
        $previousScore = $gradeMap[$this->previousGrade] ?? 99;

        if ($currentScore < $previousScore) {
            return 'improved';
        }
        if ($currentScore > $previousScore) {
            return 'declined';
        }

        return 'stable';
    }

    public function getRiskColor(string $grade): string
    {
        if (in_array($grade, ['A', 'A-', 'B+', 'B'])) {
            return 'green';
        }

        if (in_array($grade, ['B-', 'C+', 'C'])) {
            return 'yellow';
        }

        if (in_array($grade, ['C-', 'D+', 'D'])) {
            return 'orange';
        }

        return 'red';
    }
}
