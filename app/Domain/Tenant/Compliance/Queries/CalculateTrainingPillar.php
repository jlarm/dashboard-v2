<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\PillarScoreData;
use App\Enums\Role;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Support\Collection;

class CalculateTrainingPillar
{
    private const float EXPIRED_PENALTY_CAP = 25.0;

    public function __construct(
        private readonly TrainingComplianceService $trainingComplianceService,
    ) {}

    public function handle(Store $store): PillarScoreData
    {
        $users = $this->scopedUsers($store);

        if ($users->isEmpty()) {
            return PillarScoreData::notApplicable(
                key: 'training',
                label: 'Training Currency',
                reason: 'No employees assigned to this store.',
            );
        }

        $summaries = $this->trainingComplianceService->summarizeUsers($users);
        $assigned = $summaries->where('status', '!=', 'unassigned');

        if ($assigned->isEmpty()) {
            return PillarScoreData::notApplicable(
                key: 'training',
                label: 'Training Currency',
                reason: 'No courses are assigned to employees at this store.',
            );
        }

        $totalRequired = (int) $assigned->sum('total_required');
        $validCompleted = (int) $assigned->sum('valid_completed');
        $expired = (int) $assigned->sum('expired');
        $expiringSoon = (int) $assigned->sum('expiring_soon');

        $completion = $totalRequired > 0 ? ($validCompleted / $totalRequired) * 100.0 : 0.0;
        $expiredPenalty = $totalRequired > 0
            ? min(self::EXPIRED_PENALTY_CAP, ($expired / $totalRequired) * 100.0)
            : 0.0;

        $score = max(0.0, min(100.0, $completion - $expiredPenalty));

        $statusCounts = [
            'compliant' => (int) $summaries->where('status', 'compliant')->count(),
            'at_risk' => (int) $summaries->where('status', 'at_risk')->count(),
            'overdue' => (int) $summaries->where('status', 'overdue')->count(),
            'unassigned' => (int) $summaries->where('status', 'unassigned')->count(),
        ];

        return new PillarScoreData(
            key: 'training',
            label: 'Training Currency',
            applicable: true,
            score: round($score, 1),
            weight: 0.0,
            breakdown: [
                'employees' => $users->count(),
                'total_required' => $totalRequired,
                'valid_completed' => $validCompleted,
                'expired' => $expired,
                'expiring_soon' => $expiringSoon,
                'status_counts' => $statusCounts,
            ],
        );
    }

    /**
     * @return Collection<int, User>
     */
    private function scopedUsers(Store $store): Collection
    {
        return User::query()
            ->whereDoesntHave('roles', function ($query): void {
                $query->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
            })
            ->whereHas('stores', function ($query) use ($store): void {
                $query->where('stores.id', $store->id);
            })
            ->with(['roles:id,name', 'courseOverrides:user_id,course_id,type'])
            ->get();
    }
}
