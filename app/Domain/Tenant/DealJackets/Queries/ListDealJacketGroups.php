<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Queries;

use App\Domain\Tenant\DealJackets\Data\DealJacketGroupListItem;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ListDealJacketGroups
{
    /**
     * @return Collection<int, DealJacketGroupListItem>
     */
    public function handle(int $storeId, User $user): Collection
    {
        return DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->unless(
                $user->hasAnyRole(['super-admin', 'Consultant']),
                static fn (Builder $query) => $query->where('completed', true),
            )
            ->withCount('dealJackets')
            ->withSum('dealJackets as total_high_risk', 'total_high_risk')
            ->withSum('dealJackets as total_passed', 'total_passed')
            ->withSum('dealJackets as total_failed', 'total_failed')
            ->withAveragePercentage()
            ->latest()
            ->get()
            ->map(static fn (DealJacketGroup $group): DealJacketGroupListItem => DealJacketGroupListItem::fromModel($group));
    }
}
