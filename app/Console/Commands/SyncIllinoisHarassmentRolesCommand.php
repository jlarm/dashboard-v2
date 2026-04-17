<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Override;
use Spatie\Permission\Models\Role;

class SyncIllinoisHarassmentRolesCommand extends Command
{
    private const string EMPLOYEE_COURSE_SLUG = 'sexual-harassment-illinois';
    private const string MANAGER_COURSE_SLUG = 'sexual-harassment-illinois-m';
    private const array EMPLOYEE_ROLES = ['Employee', 'Porter/Driver'];
    private const array MANAGER_ROLES = ['Owner', 'GM', 'CFO', 'GSM', 'Manager'];

    #[Override]
    protected $signature = 'courses:sync-illinois-harassment-roles
        {--tenant= : Tenant ID to run against}
        {--dry-run : Preview changes without updating records}';

    #[Override]
    protected $description = 'Assign correct roles to Illinois harassment courses (employee vs manager variants)';

    public function handle(): int
    {
        $tenantId = $this->option('tenant');
        $dryRun = (bool) $this->option('dry-run');

        $tenants = Dealership::query()
            ->when(
                is_string($tenantId) && $tenantId !== '',
                fn (Builder $query): Builder => $query->where('id', $tenantId)
            )
            ->orderBy('id')
            ->pluck('id');

        if ($tenants->isEmpty()) {
            $this->warn('No tenants matched the filter.');

            return self::SUCCESS;
        }

        $updatedCount = 0;
        $missingCount = 0;

        tenancy()->runForMultiple($tenants, function ($tenant) use ($dryRun, &$updatedCount, &$missingCount): void {
            /** @var Dealership $tenant */
            $employeeCourse = Course::query()->where('slug', self::EMPLOYEE_COURSE_SLUG)->first();
            $managerCourse = Course::query()->where('slug', self::MANAGER_COURSE_SLUG)->first();

            if (! $employeeCourse || ! $managerCourse) {
                $missingCount++;
                $this->warn("{$tenant->id}: one or both Illinois courses not found.");

                return;
            }

            $employeeRoleIds = Role::query()->whereIn('name', self::EMPLOYEE_ROLES)->pluck('id');
            $managerRoleIds = Role::query()->whereIn('name', self::MANAGER_ROLES)->pluck('id');

            $this->line("{$tenant->id}: {$employeeCourse->slug} -> roles: ".implode(', ', self::EMPLOYEE_ROLES));
            $this->line("{$tenant->id}: {$managerCourse->slug} -> roles: ".implode(', ', self::MANAGER_ROLES));

            if (! $dryRun) {
                $employeeCourse->roles()->sync($employeeRoleIds);
                $managerCourse->roles()->sync($managerRoleIds);
            }

            $updatedCount++;
        });

        $prefix = $dryRun ? '[dry-run] ' : '';
        $this->info("{$prefix}Done. updated={$updatedCount}, missing={$missingCount}");

        return self::SUCCESS;
    }
}
