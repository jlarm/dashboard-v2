<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;

class DealJacketReportPdfTestController extends Controller
{
    public function __invoke()
    {
        $dealJacketGroup = DealJacketGroup::with(['dealJackets.user', 'store'])
            ->withCount('dealJackets')
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->latest()
            ->first();

        if (! $dealJacketGroup) {
            return 'No deal jacket groups found. Please create one first.';
        }

        $dealJackets = $dealJacketGroup->dealJackets()
            ->with(['user'])
            ->get();

        $issuesByUser = [];
        $dealJacketDetails = [];
        $dealJacketsByUser = [];

        foreach ($dealJackets as $dealJacket) {
            $userName = $dealJacket->user?->name ?? 'House';
            $issueCount = 0;

            if (! isset($issuesByUser[$userName])) {
                $issuesByUser[$userName] = 0;
            }

            $dealJacketIssues = [];

            if (is_array($dealJacket->responses)) {
                foreach ($dealJacket->responses as $response) {
                    if (isset($response['answer']) && $response['answer'] === 'no') {
                        $issueCount++;

                        $statement = $response['statement'] ?? 'Unknown question';

                        $dealJacketIssues[] = [
                            'statement' => $statement,
                            'comment' => $response['comment'] ?? '',
                        ];
                    }
                }
            }

            $issuesByUser[$userName] += $issueCount;

            $detail = [
                'customer_name' => $dealJacket->customer_name,
                'customer_deal_number' => $dealJacket->customer_deal_number,
                'user_name' => $userName,
                'purchase_type' => $dealJacket->purchase_type,
                'vehicle_type' => $dealJacket->vehicle_type,
                'mileage' => $dealJacket->mileage,
                'date_of_deal_jacket' => $dealJacket->date_of_deal_jacket,
                'issues' => $dealJacketIssues,
            ];

            $dealJacketDetails[] = $detail;

            if ($dealJacketIssues !== []) {
                if (! isset($dealJacketsByUser[$userName])) {
                    $dealJacketsByUser[$userName] = [];
                }

                $dealJacketsByUser[$userName][] = $detail;
            }
        }

        return view('dealer.audit.deal-jacket.pdf-report', [
            'dealJacketGroup' => $dealJacketGroup,
            'user' => User::query()->first(),
            'issuesByUser' => $issuesByUser,
            'dealJacketDetails' => $dealJacketDetails,
            'dealJacketsByUser' => $dealJacketsByUser,
            'totalIssues' => $dealJacketGroup->total_failed,
        ]);
    }
}
