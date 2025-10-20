<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;

class CommonIssuesChart extends Component
{
    protected $listeners = ['refreshDealJacketGroups' => '$refresh'];

    public function render(): View
    {
        $storeId = app('currentStore');

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
            fn ($statement): string => $this->truncateLabel($statement),
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
}
