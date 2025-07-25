<?php

namespace App\Queries;

use App\Enums\AuditTypes;
use App\Models\Dealer\Store;
use App\Models\RemediationReminderPreference;
use App\Models\User;
use Illuminate\Support\Collection;

class GetRemediationReminderUsers
{
    public function __construct(protected Store $store, protected AuditTypes $auditType) {}

    public static function execute(Store $store, AuditTypes $auditType): Collection
    {
        $userIds = RemediationReminderPreference::query()
            ->where('enabled', true)
            ->where('audit_type', $auditType)
            ->get()
            ->pluck('user_id')
            ->toArray();

        $users = tenant('locations') ? $store->users() : User::query();

        return $users->permission('create-users')->whereIn('id', $userIds)->select(['id', 'name', 'email'])->get();
    }
}
