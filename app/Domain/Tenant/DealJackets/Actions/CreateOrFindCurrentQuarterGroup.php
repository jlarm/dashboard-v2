<?php

declare(strict_types=1);

namespace App\Domain\Tenant\DealJackets\Actions;

use App\Models\Dealer\Audit\DealJacketGroup;
use Illuminate\Support\Facades\Date;

class CreateOrFindCurrentQuarterGroup
{
    /**
     * Returns the current-quarter DealJacketGroup for the given store. If none
     * exists yet, creates it. The boolean tuple member tells the caller whether
     * the group was already there (true) or freshly created (false).
     *
     * @return array{DealJacketGroup, bool}
     */
    public function handle(int $storeId): array
    {
        $now = Date::now();

        $existing = DealJacketGroup::query()
            ->where('store_id', $storeId)
            ->whereBetween('created_at', [$now->copy()->startOfQuarter(), $now->copy()->endOfQuarter()])
            ->first();

        if ($existing instanceof DealJacketGroup) {
            return [$existing, true];
        }

        $group = DealJacketGroup::query()->create(['store_id' => $storeId]);

        return [$group, false];
    }
}
