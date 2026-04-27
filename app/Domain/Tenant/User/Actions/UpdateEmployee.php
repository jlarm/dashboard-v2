<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use App\Domain\Tenant\User\Queries\GetEmployees;
use App\Enums\Role as RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Spatie\Permission\PermissionRegistrar;

class UpdateEmployee
{
    public function __construct(private readonly PermissionRegistrar $permissionRegistrar) {}

    /**
     * @param  list<int>|null  $storeIds
     * @param  list<string>  $auditTypes
     */
    public function handle(
        User $user,
        ?int $departmentId,
        int $roleId,
        bool $qualifiedIndividual,
        ?array $storeIds = null,
        array $auditTypes = [],
    ): void {
        $role = Role::query()->findOrFail($roleId);

        if (in_array($role->name, [RoleEnum::SuperAdmin->value, RoleEnum::Consultant->value], true)) {
            throw new RuntimeException('Cannot assign privileged roles to an employee.');
        }

        DB::transaction(function () use ($user, $departmentId, $role, $qualifiedIndividual, $storeIds, $auditTypes): void {
            $user->update(['department_id' => $departmentId]);

            $roles = [$role->name];
            if ($qualifiedIndividual) {
                $roles[] = RoleEnum::QualifiedIndividual->value;
            }

            $user->syncRoles($roles);

            if ($storeIds !== null) {
                $this->syncStores($user, $storeIds);
            }

            $this->syncAuditTypes($user, $auditTypes);
        });

        $this->permissionRegistrar->forgetCachedPermissions();

        GetEmployees::bustTrainingCounts();
    }

    /**
     * @param  list<int>  $storeIds
     */
    private function syncStores(User $user, array $storeIds): void
    {
        $user->stores()->sync($storeIds);

        $currentStoreId = (int) $user->current_store_id;
        if ($currentStoreId !== 0 && ! in_array($currentStoreId, $storeIds, true)) {
            $user->update([
                'current_store_id' => count($storeIds) === 1 ? $storeIds[0] : null,
            ]);
        }

        if (count($storeIds) <= 1) {
            $user->update(['primary_store_id' => null]);
        }
    }

    /**
     * @param  list<string>  $auditTypes
     */
    private function syncAuditTypes(User $user, array $auditTypes): void
    {
        $user->remediationReminderPreferences()->delete();

        foreach ($auditTypes as $auditType) {
            $user->remediationReminderPreferences()->create([
                'audit_type' => $auditType,
                'enabled' => true,
            ]);
        }
    }
}
