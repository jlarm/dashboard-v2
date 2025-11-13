<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\BodyShop;

use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public $store;
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function mount(): void
    {
        $this->store = Store::with('bodyShopAudits')->where('id', app('currentStore'))->firstOrFail();
    }

    public function render(): View
    {
        $bodyShopAudits = $this->store->bodyShopAudits->sortByDesc('audit_date');
        $audits = $this->store->bodyShopViolationAudits->sortByDesc('date');

        // Prepare chart data combining both audit types
        $chartData = collect();

        // Add BodyShopViolationAudits to chart data
        foreach ($audits as $audit) {
            if ($audit->date && $audit->grade) {
                $chartData->push([
                    'date' => $audit->date,
                    'grade' => $audit->grade,
                    'violations' => $audit->violation_count,
                    'remediations' => $audit->remediation_count,
                ]);
            }
        }

        // Add BodyShopAudits to chart data (if they have a grade field)
        foreach ($bodyShopAudits as $audit) {
            if ($audit->audit_date && isset($audit->grade)) {
                $chartData->push([
                    'date' => $audit->audit_date,
                    'grade' => $audit->grade,
                    'violations' => $audit->violations()->count(),
                    'remediations' => 0, // BodyShopAudits may not have remediation tracking
                ]);
            }
        }

        // Sort by date and prepare for chart
        $chartData = $chartData->take(4);
        $chartData = $chartData->sortBy('date')->values();
        $chartLabels = $chartData->map(fn ($item) => $item['date']->format('M \'y'))->toArray();

        // Convert letter grades to numeric values for plotting
        $gradeMap = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];
        $chartGradesNumeric = $chartData->map(fn ($item) => $gradeMap[mb_strtoupper($item['grade'])] ?? 0)->toArray();
        $chartGradesLetters = $chartData->map(fn ($item) => mb_strtoupper($item['grade']))->toArray();

        // Prepare violations and remediations data for spline chart
        $chartViolations = $chartData->map(fn ($item) => $item['violations'])->toArray();
        $chartRemediations = $chartData->map(fn ($item) => $item['remediations'])->toArray();

        return view('livewire.dealer.audit.body-shop.index', [
            'bodyShopAudits' => $bodyShopAudits,
            'audits' => $audits,
            'chartLabels' => $chartLabels,
            'chartGradesNumeric' => $chartGradesNumeric,
            'chartGradesLetters' => $chartGradesLetters,
            'chartViolations' => $chartViolations,
            'chartRemediations' => $chartRemediations,
        ])->layout('components.dealer-app');
    }
}
