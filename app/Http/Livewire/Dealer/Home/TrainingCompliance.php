<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Home;

use App\Models\User;
use App\Services\AlertCenterService;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TrainingCompliance extends Component
{
    public bool $readyToLoad = false;

    /**
     * @var array{
     *     employees: int,
     *     compliant: int,
     *     at_risk: int,
     *     overdue: int,
     *     unassigned: int,
     *     incomplete_courses: int,
     *     expired_courses: int,
     *     expiring_soon_courses: int
     * }
     */
    public array $counts = [
        'employees' => 0,
        'compliant' => 0,
        'at_risk' => 0,
        'overdue' => 0,
        'unassigned' => 0,
        'incomplete_courses' => 0,
        'expired_courses' => 0,
        'expiring_soon_courses' => 0,
    ];

    /**
     * @var array<int, array{
     *     user: User,
     *     status: string,
     *     status_label: string,
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int
     * }>
     */
    public array $alerts = [];

    public function loadStats(): void
    {
        $this->readyToLoad = true;
    }

    public function render(): View
    {
        if ($this->readyToLoad) {
            $this->hydrateComplianceData();
        }

        return view('livewire.dealer.home.training-compliance');
    }

    private function hydrateComplianceData(): void
    {
        $viewer = auth()->user();

        if (! $viewer instanceof User) {
            $this->alerts = [];

            return;
        }

        $service = resolve(AlertCenterService::class);
        $users = $service->scopedEmployeeQuery($viewer)->get();
        $summaries = $service->summarizeUsers($users);
        $alerts = $service->buildTrainingAlerts($users, $summaries)->take(5)->values();

        $this->counts = $service->summarizeCounts($summaries);
        $this->alerts = $this->normalizeAlerts($alerts);
    }

    /**
     * @param  Collection<int, array{
     *     user: User,
     *     status: string,
     *     status_label: string,
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int
     * }>  $alerts
     * @return array<int, array{
     *     user: User,
     *     status: string,
     *     status_label: string,
     *     total_required: int,
     *     valid_completed: int,
     *     not_completed: int,
     *     expired: int,
     *     expiring_soon: int
     * }>
     */
    private function normalizeAlerts(Collection $alerts): array
    {
        return $alerts->values()->all();
    }
}
