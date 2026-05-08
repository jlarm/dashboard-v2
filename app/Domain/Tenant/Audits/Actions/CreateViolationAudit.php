<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Audits\Actions;

use App\Enums\ViolationAuditType;
use App\Models\Dealer\Audit\Contracts\ViolationAudit;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreateViolationAudit
{
    public function handle(ViolationAuditType $type, Store $store, User $user): ViolationAudit&Model
    {
        $modelClass = $type->modelClass();

        /** @var ViolationAudit&Model $audit */
        $audit = $modelClass::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'store_id' => $store->id,
            'date' => now()->format('Y-m-d'),
        ]);

        return $audit;
    }
}
