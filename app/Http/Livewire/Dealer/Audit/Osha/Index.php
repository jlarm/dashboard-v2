<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Audit\Osha;

use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class Index extends Component
{
    public ?Store $store = null;

    #[Override]
    protected $listeners = [
        'refreshAudits' => '$refresh',
    ];

    public function mount(): void
    {
        /** @var Store|null $currentStore */
        $currentStore = app()->bound('currentStoreModel') ? resolve('currentStoreModel') : null;
        $this->store = $currentStore;
    }

    public function render(): View
    {
        $storeIds = $this->resolveScopedStoreIds();
        $oshaAudits = $storeIds->isEmpty()
            ? collect()
            : OshaAudit::query()->whereIn('store_id', $storeIds)->with('violations')->latest('audit_date')->get();
        $audits = $storeIds->isEmpty()
            ? collect()
            : OshaViolationAudit::query()
                ->whereIn('store_id', $storeIds)
                ->withCount([
                    'violations as violation_count',
                    'violations as remediation_count' => fn ($q) => $q->whereHas('remediation', fn ($q) => $q->where('completed', true)),
                ])
                ->latest('date')
                ->get();

        $chartData = $this->prepareChartData($audits, $oshaAudits);

        return view('livewire.dealer.audit.osha.index', [
            'store' => $this->store,
            'oshaAudits' => $oshaAudits,
            'audits' => $audits,
            'chartLabels' => $chartData['labels'],
            'chartGradesNumeric' => $chartData['gradesNumeric'],
            'chartGradesLetters' => $chartData['gradesLetters'],
            'chartViolations' => $chartData['violations'],
            'chartRemediations' => $chartData['remediations'],
        ])->layout('components.dealer-app');
    }

    /**
     * @return array{labels: array<string>, gradesNumeric: array<int>, gradesLetters: array<string>, violations: array<int>, remediations: array<int>}
     */
    private function prepareChartData(Collection $violationAudits, Collection $legacyAudits): array
    {
        $gradeMap = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'F' => 0];

        $chartData = collect();

        foreach ($violationAudits as $audit) {
            if ($audit->date && $audit->grade) {
                $chartData->push([
                    'date' => $audit->date,
                    'grade' => $audit->grade,
                    'violations' => $audit->violation_count,
                    'remediations' => $audit->remediation_count,
                ]);
            }
        }

        foreach ($legacyAudits as $audit) {
            if ($audit->audit_date && $audit->grade !== null) {
                $chartData->push([
                    'date' => $audit->audit_date,
                    'grade' => $audit->grade,
                    'violations' => $audit->violations->count(),
                    'remediations' => 0,
                ]);
            }
        }

        $sorted = $chartData->sortByDesc('date')->take(4)->sortBy('date')->values();

        return [
            'labels' => $sorted->map(fn ($item) => $item['date']->format('M \'y'))->toArray(),
            'gradesNumeric' => $sorted->map(fn ($item): int => $gradeMap[mb_strtoupper((string) $item['grade'])] ?? 0)->all(),
            'gradesLetters' => $sorted->map(fn ($item): string => mb_strtoupper((string) $item['grade']))->all(),
            'violations' => $sorted->map(fn ($item) => $item['violations'])->toArray(),
            'remediations' => $sorted->map(fn ($item) => $item['remediations'])->toArray(),
        ];
    }

    private function resolveScopedStoreIds(): Collection
    {
        /** @var Collection $storeIds */
        $storeIds = resolve('scopedStoreIds');

        return $storeIds;
    }
}
