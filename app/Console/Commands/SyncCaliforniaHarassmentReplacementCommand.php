<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Course as CentralCourse;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class SyncCaliforniaHarassmentReplacementCommand extends Command
{
    private const CALIFORNIA_COURSE_SLUG = 'sexual-harassment-training-in-california';
    private const TARGET_STATES = ['California'];
    private const REPLACED_SLUGS = ['sexual-harassment-e', 'sexual-harassment-m'];

    protected $signature = 'courses:sync-california-harassment-replacement
        {--tenant= : Tenant ID to run against}
        {--dry-run : Preview changes without updating records}';
    protected $description = 'Ensure California harassment course replaces sexual-harassment-e and sexual-harassment-m';

    public function handle(): int
    {
        $tenantId = $this->option('tenant');
        $dryRun = (bool) $this->option('dry-run');

        $this->syncCentralCourse($dryRun);

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

        $updatedTenantCount = 0;
        $missingTenantCount = 0;

        tenancy()->runForMultiple($tenants, function ($tenant) use ($dryRun, &$updatedTenantCount, &$missingTenantCount): void {
            /** @var Dealership $tenant */
            $course = TenantCourse::query()
                ->where('slug', self::CALIFORNIA_COURSE_SLUG)
                ->first();

            if (! $course) {
                $missingTenantCount++;
                $this->warn("{$tenant->id}: course not found.");

                return;
            }

            $currentStates = $course->states_required ?? [];
            $currentReplacements = $course->replaces_course_slugs ?? [];

            $this->line(
                "{$tenant->id}: states_required=".json_encode($currentStates)
                .' -> '.json_encode(self::TARGET_STATES)
                .', replaces_course_slugs='.json_encode($currentReplacements)
                .' -> '.json_encode(self::REPLACED_SLUGS)
            );

            if (! $dryRun) {
                $course->update([
                    'states_required' => self::TARGET_STATES,
                    'replaces_course_slugs' => self::REPLACED_SLUGS,
                ]);
            }

            $updatedTenantCount++;
        });

        $prefix = $dryRun ? '[dry-run] ' : '';
        $this->info("{$prefix}Done. updated_tenants={$updatedTenantCount}, missing_tenants={$missingTenantCount}");

        return self::SUCCESS;
    }

    private function syncCentralCourse(bool $dryRun): void
    {
        $course = CentralCourse::query()
            ->where('slug', self::CALIFORNIA_COURSE_SLUG)
            ->first();

        if (! $course) {
            $this->warn('central: course not found.');

            return;
        }

        $currentStates = $course->states_required ?? [];
        $currentReplacements = $course->replaces_course_slugs ?? [];

        $this->line(
            'central: states_required='.json_encode($currentStates)
            .' -> '.json_encode(self::TARGET_STATES)
            .', replaces_course_slugs='.json_encode($currentReplacements)
            .' -> '.json_encode(self::REPLACED_SLUGS)
        );

        if (! $dryRun) {
            $course->update([
                'states_required' => self::TARGET_STATES,
                'replaces_course_slugs' => self::REPLACED_SLUGS,
            ]);
        }
    }
}
