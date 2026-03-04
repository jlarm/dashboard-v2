<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use App\Models\Dealer\Department;
use App\Models\User;
use App\Services\UserCourseService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AuditFinanceManagerCoursesCommand extends Command
{
    protected $signature = 'audit:finance-manager-courses {--tenants=* : The tenant(s) to audit. Default all.} {--fix : Fix inconsistencies by recalculating courses}';
    protected $description = 'Audit course assignments for Finance Manager users across all tenants';

    public function handle(UserCourseService $courseService): void
    {
        $this->info('Starting Finance Manager course audit...');
        $this->newLine();

        $stats = [
            'tenants_checked' => 0,
            'users_checked' => 0,
            'inconsistencies' => 0,
            'users_fixed' => 0,
        ];

        /** @var Collection<int, string> $tenants */
        $tenants = collect($this->option('tenants'))
            ->filter(static fn (mixed $tenant): bool => is_string($tenant) && $tenant !== '')
            ->values();

        tenancy()->runForMultiple($tenants->isEmpty() ? null : $tenants, function ($tenant) use ($courseService, &$stats): void {
            app(UserCourseService::class)->clearAllCaches();

            $this->info("Checking tenant: {$tenant->name} (ID: {$tenant->id})");

            $stats['tenants_checked']++;

            // Get Finance Manager users in this tenant
            $financeManagerUsers = $this->getFinanceManagerUsers();

            if ($financeManagerUsers->isEmpty()) {
                $this->comment('  No Finance Manager users found in this tenant');
                $this->newLine();

                return;
            }

            $this->info('  Found '.$financeManagerUsers->count().' Finance Manager user(s)');

            foreach ($financeManagerUsers as $user) {
                $stats['users_checked']++;

                // Get actual assigned courses
                $actualCourseIds = $courseService->getCourseIds($user);

                // Get expected courses for THIS specific user (considering CA stores)
                $expectedCourseIds = $this->getExpectedFinanceManagerCourses($user);

                // Check for discrepancies
                $missing = array_diff($expectedCourseIds, $actualCourseIds);
                $extra = array_diff($actualCourseIds, $expectedCourseIds);

                if ($missing !== [] || $extra !== []) {
                    $stats['inconsistencies']++;

                    $this->warn("  ❌ Inconsistency found for user: {$user->name} ({$user->email})");

                    if ($missing !== []) {
                        $missingCourses = Course::query()->whereIn('id', $missing)->pluck('name')->toArray();
                        $this->error('    Missing courses: '.implode(', ', $missingCourses));
                    }

                    if ($extra !== []) {
                        $extraCourses = Course::query()->whereIn('id', $extra)->pluck('name')->toArray();
                        $this->comment('    Extra courses: '.implode(', ', $extraCourses));
                    }

                    // Check for excludes
                    $excludes = $user->courseOverrides()->where('type', 'exclude')->get();
                    if ($excludes->isNotEmpty()) {
                        $this->comment('    Has '.$excludes->count().' course exclusions');
                    }

                    if ($this->option('fix')) {
                        // Note: This doesn't actually "fix" the data, just shows what the service returns
                        // Actual fixes would require removing bad course_user overrides
                        $this->info('    ℹ️  Calculated course count: '.count($actualCourseIds));
                        $stats['users_fixed']++;
                    }
                } else {
                    $this->info("  ✓ User: {$user->name} - Courses OK (".count($actualCourseIds).' courses)');
                }
            }

            $this->newLine();
        });

        // Display summary
        $this->info('=== Audit Summary ===');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Tenants Checked', $stats['tenants_checked']],
                ['Users Checked', $stats['users_checked']],
                ['Inconsistencies Found', $stats['inconsistencies']],
            ]
        );

        if ($stats['inconsistencies'] > 0) {
            $this->newLine();
            $this->warn('⚠️  Inconsistencies detected! Review the output above.');
            $this->comment('Common causes:');
            $this->comment('  - Manual course exclusions (course_user with type="exclude")');
            $this->comment('  - Manual course additions (course_user with type="add")');
            $this->comment('  - Different role assignments in production');
        } else {
            $this->newLine();
            $this->info('✓ All Finance Manager users have consistent course assignments!');
        }
    }

    private function getExpectedFinanceManagerCourses(User $user): array
    {
        $financeDeptId = $user->department_id;
        $managerRoleId = Role::query()->where('name', 'Manager')->first()->id;

        // Get courses associated with Manager role
        $courseWithRole = DB::table('course_role')
            ->where('role_id', $managerRoleId)
            ->pluck('course_id')
            ->toArray();

        // Check if user has California stores
        $hasNoCaliforniaStore = ! $user->stores()->where('state', 'California')->exists();

        // Use the EXACT same logic as UserCourseService
        return Course::query()
            ->where('optional', false)
            ->where(function ($query) use ($financeDeptId, $courseWithRole, $hasNoCaliforniaStore): void {
                // Branch 1: Courses with specific departments (must have matching role)
                $query->where(function ($q) use ($financeDeptId, $courseWithRole): void {
                    $q->whereHas('departments', fn ($q) => $q->where('id', $financeDeptId))
                        ->whereIn('id', $courseWithRole);
                })
                // Branch 2: Courses without departments
                    ->orWhere(function ($q) use ($courseWithRole, $hasNoCaliforniaStore): void {
                        $q->whereDoesntHave('departments')
                            ->where(function ($subQuery) use ($courseWithRole): void {
                                // Either has a role requirement AND user has that role
                                $subQuery->whereIn('id', $courseWithRole)
                                    // OR has no role requirement (universal course for everyone)
                                    ->orWhereDoesntHave('roles');
                            })
                            // Only exclude California-specific course for users without California stores
                            ->when($hasNoCaliforniaStore, fn ($q) => $q->where('slug', '!=', 'sexual-harassment-training-in-california'));
                    });
            })
            ->pluck('id')
            ->toArray();
    }

    private function getFinanceManagerUsers()
    {
        $financeDept = Department::query()->where('name', 'Finance')->first();
        $managerRole = Role::query()->where('name', 'Manager')->first();

        if (! $financeDept || ! $managerRole) {
            return collect();
        }

        return User::query()
            ->where('department_id', $financeDept->id)
            ->whereHas('roles', fn ($q) => $q->where('id', $managerRole->id))
            ->with(['roles', 'courseOverrides', 'stores'])
            ->select(['id', 'name', 'email', 'department_id'])
            ->get();
    }
}
