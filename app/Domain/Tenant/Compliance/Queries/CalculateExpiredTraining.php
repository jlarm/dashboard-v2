<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Compliance\Queries;

use App\Enums\Role;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\TrainingComplianceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CalculateExpiredTraining
{
    public function __construct(
        private readonly TrainingComplianceService $service,
    ) {}

    /**
     * Expired-training counts for users assigned to a single store.
     *
     * Used by the daily snapshot for per-store rows. Multi-store users will
     * appear in each of their stores' rows; deduping happens in handleForTenant.
     *
     * @return array{count:int, expiring_soon_count:int}
     */
    public function handleForStore(Store $store): array
    {
        return $this->summarize($this->scopedUsers($store->id));
    }

    /**
     * Tenant-wide deduped counts across every assigned employee in the tenant.
     *
     * Used by the daily snapshot to write the tenant-level row, and by the
     * dashboard when the request scope spans multiple stores.
     *
     * @return array{count:int, expiring_soon_count:int}
     */
    public function handleForTenant(): array
    {
        return $this->summarize($this->scopedUsers());
    }

    /**
     * Counts for the union of users assigned to any of the given stores.
     * The user set is deduped, so a user in two scoped stores counts once.
     *
     * @param  Collection<int, int>|array<int, int>  $storeIds
     * @return array{count:int, expiring_soon_count:int}
     */
    public function handleForStores(Collection|array $storeIds): array
    {
        $ids = collect($storeIds)
            ->map(static fn (int $id): int => $id)
            ->filter()
            ->values();

        if ($ids->isEmpty()) {
            return ['count' => 0, 'expiring_soon_count' => 0];
        }

        return $this->summarize($this->scopedUsers(null, array_values($ids->all())));
    }

    /**
     * @param  Collection<int, User>  $users
     * @return array{count:int, expiring_soon_count:int}
     */
    private function summarize(Collection $users): array
    {
        if ($users->isEmpty()) {
            return ['count' => 0, 'expiring_soon_count' => 0];
        }

        $summaries = $this->service->summarizeUsers($users);

        return [
            'count' => (int) $summaries->sum('expired'),
            'expiring_soon_count' => (int) $summaries->sum('expiring_soon'),
        ];
    }

    /**
     * Eligible employees, optionally scoped to one store or a list of store ids.
     * Mirrors CalculateTrainingPillar::scopedUsers — excludes super-admin and
     * Consultant roles since they don't carry training requirements.
     *
     * @param  list<int>|null  $storeIds
     * @return Collection<int, User>
     */
    private function scopedUsers(?int $singleStoreId = null, ?array $storeIds = null): Collection
    {
        return User::query()
            ->whereDoesntHave('roles', function (Builder $query): void {
                $query->whereIn('name', [Role::SuperAdmin->value, Role::Consultant->value]);
            })
            ->when($singleStoreId !== null, function (Builder $query) use ($singleStoreId): void {
                $query->whereHas('stores', function (Builder $inner) use ($singleStoreId): void {
                    $inner->where('stores.id', $singleStoreId);
                });
            })
            ->when($storeIds !== null, function (Builder $query) use ($storeIds): void {
                $query->whereHas('stores', function (Builder $inner) use ($storeIds): void {
                    $inner->whereIn('stores.id', $storeIds);
                });
            })
            ->with(['roles:id,name', 'courseOverrides:user_id,course_id,type'])
            ->get();
    }
}
