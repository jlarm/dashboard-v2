<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Audit\DealJacket\Components;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\View\View;
use Livewire\Component;

class IssueList extends Component
{
    public DealJacketGroup $dealJacketGroup;

    public function render(): View
    {
        $issues = $this->dealJacketGroup
            ->dealJackets()
            ->select('responses')
            ->get();

        $issueCounts = [];

        foreach ($issues as $issue) {
            foreach ($issue->responses as $response) {
                if ($response['answer'] === 'no') {
                    $issueCounts[] = $response;
                }
            }
        }

        $topIssues = collect($issueCounts)
            ->groupBy('statement')
            ->map(fn ($group): array => [
                'statement' => $group->first()['statement'],
                'count' => $group->count(),
            ])
            ->sortByDesc('count')
            ->take(7)
            ->values();

        return view('livewire.tenant.audit.deal-jacket.components.issue-list', [
            'issues' => $topIssues,
        ]);
    }
}
