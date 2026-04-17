<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Illuminate\View\View;
use Livewire\Component;
use Override;

class CommonIssuesChart extends Component
{
    #[Override]
    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = $this->resolveStoreId();

        $responses = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->where('completed', true)
            ->latest()
            ->limit(4)
            ->with('dealJackets')
            ->get()
            ->flatMap(fn ($group) => $group->dealJackets)
            ->pluck('responses')
            ->filter();

        $issuesCounts = [];

        foreach ($responses as $responseArray) {
            foreach ($responseArray as $response) {
                if (isset($response['answer'], $response['statement']) && $response['answer'] === 'no') {
                    $statement = $response['statement'];
                    $issuesCounts[$statement] = ($issuesCounts[$statement] ?? 0) + 1;
                }
            }
        }

        arsort($issuesCounts);
        $topIssues = array_slice($issuesCounts, 0, 5, true);

        $labels = array_map(
            fn (int|string $statement): string => $this->truncateLabel($statement),
            array_keys($topIssues)
        );

        return view('livewire.tenant.audit.deal-jacket.components.common-issues-chart', [
            'labels' => $labels,
            'data' => array_values($topIssues),
        ]);
    }

    private function truncateLabel(string $label, int $maxLength = 40): string
    {
        if (mb_strlen($label) <= $maxLength) {
            return $label;
        }

        return mb_substr($label, 0, $maxLength).'...';
    }

    private function resolveStoreId(): ?int
    {
        $currentStore = app()->bound('currentStore') ? resolve('currentStore') : null;

        if (is_numeric($currentStore)) {
            return (int) $currentStore;
        }

        $scopedStoreIds = app()->bound('scopedStoreIds') ? resolve('scopedStoreIds') : collect();
        $firstScopedStoreId = $scopedStoreIds->first();

        if (is_numeric($firstScopedStoreId)) {
            return (int) $firstScopedStoreId;
        }

        $fallbackStoreId = Store::query()->orderBy('id')->value('id');

        return is_numeric($fallbackStoreId) ? (int) $fallbackStoreId : null;
    }
}
