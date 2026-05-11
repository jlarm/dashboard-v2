<?php

declare(strict_types=1);

namespace App\Domain\Tenant\IndividualAudits\Actions;

use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Str;

class CreateIndividualAudit
{
    /**
     * Creates a new IndividualAudit row. If $parent is set, the new audit is
     * linked as a child (a deal jacket inside the parent's quarterly audit).
     */
    public function handle(User $user, Store $store, ?IndividualAudit $parent = null): IndividualAudit
    {
        return IndividualAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'store_id' => $store->id,
            'parent_id' => $parent?->id,
            'audit_date' => now()->toDateString(),
            'deal_jacket_date' => now()->toDateString(),
            'draft' => true,
        ]);
    }
}
