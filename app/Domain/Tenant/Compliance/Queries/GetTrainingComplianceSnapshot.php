<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Domain\Tenant\Compliance\Data\TrainingComplianceAlertData;
use App\Domain\Tenant\Compliance\Data\TrainingComplianceSnapshotData;
use App\Enums\Role;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetTrainingComplianceSnapshot
{
    private const int PRIORITY_ALERT_LIMIT = 5;

    /**
     * Status sort order. Unassigned employees rise to the top so admins
     * notice missing course assignments before chasing overdue completions.
     *
     * @var array<string, int>
     */
    private const array STATUS_RANK = [
        'unassigned' => 0,
        'overdue' => 1,
        'at_risk' => 2,
        'compliant' => 3,
    ];

    public function __construct(
        private readonly TrainingComplianceService $service,
    ) {}

    /**
     * Aggregate training-compliance counts and the top non-compliant
     * employees for the given scoped stores.
     *
     * @param  list<int>  $storeIds
     */
    public function handleForStores(array $storeIds): TrainingComplianceSnapshotData
    {
        if ($storeIds === []) {
            return $this->emptySnapshot();
        }

        $users = User::query()
            ->whereDoesntHave('roles', function (Builder $query): void {
                $query->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
            })
            ->whereHas('stores', function (Builder $query) use ($storeIds): void {
                $query->whereIn('stores.id', $storeIds);
            })
            ->with(['roles:id,name', 'courseOverrides:user_id,course_id,type'])
            ->get();

        if ($users->isEmpty()) {
            return $this->emptySnapshot();
        }

        $summaries = $this->service->summarizeUsers($users);

        $counts = ['overdue' => 0, 'at_risk' => 0, 'compliant' => 0, 'unassigned' => 0];

        foreach ($summaries as $summary) {
            $status = $summary['status'];
            if (array_key_exists($status, $counts)) {
                $counts[$status]++;
            }
        }

        $alerts = $this->buildAlerts($users, $summaries);

        return new TrainingComplianceSnapshotData(
            overdue: $counts['overdue'],
            at_risk: $counts['at_risk'],
            compliant: $counts['compliant'],
            unassigned: $counts['unassigned'],
            employees: $users->count(),
            priority_alerts: $alerts,
        );
    }

    /**
     * @param  Collection<int, User>  $users
     * @param  Collection<int, array{total_required:int, valid_completed:int, not_completed:int, expired:int, expiring_soon:int, status:string}>  $summaries
     * @return list<TrainingComplianceAlertData>
     */
    private function buildAlerts(Collection $users, Collection $summaries): array
    {
        return $users
            ->map(function (User $user) use ($summaries): ?array {
                $summary = $summaries->get($user->id);

                if ($summary === null) {
                    return null;
                }

                $status = $summary['status'];

                if ($status !== 'overdue' && $status !== 'at_risk' && $status !== 'unassigned') {
                    return null;
                }

                return [
                    'user' => $user,
                    'summary' => $summary,
                ];
            })
            ->filter()
            ->sort(static function (array $a, array $b): int {
                $rankA = self::STATUS_RANK[$a['summary']['status']] ?? PHP_INT_MAX;
                $rankB = self::STATUS_RANK[$b['summary']['status']] ?? PHP_INT_MAX;

                if ($rankA !== $rankB) {
                    return $rankA <=> $rankB;
                }

                $unfinishedA = $a['summary']['not_completed'] + $a['summary']['expired'];
                $unfinishedB = $b['summary']['not_completed'] + $b['summary']['expired'];

                if ($unfinishedA !== $unfinishedB) {
                    return $unfinishedB <=> $unfinishedA;
                }

                return ((string) $a['user']->name) <=> ((string) $b['user']->name);
            })
            ->take(self::PRIORITY_ALERT_LIMIT)
            ->map(static fn (array $row): TrainingComplianceAlertData => new TrainingComplianceAlertData(
                user_slug: (string) $row['user']->slug,
                name: (string) $row['user']->name,
                valid_completed: (int) $row['summary']['valid_completed'],
                total_required: (int) $row['summary']['total_required'],
                status: (string) $row['summary']['status'],
            ))
            ->values()
            ->all();
    }

    private function emptySnapshot(): TrainingComplianceSnapshotData
    {
        return new TrainingComplianceSnapshotData(
            overdue: 0,
            at_risk: 0,
            compliant: 0,
            unassigned: 0,
            employees: 0,
            priority_alerts: [],
        );
    }
}
