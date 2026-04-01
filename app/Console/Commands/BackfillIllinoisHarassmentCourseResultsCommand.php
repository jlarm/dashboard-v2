<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealership;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class BackfillIllinoisHarassmentCourseResultsCommand extends Command
{
    private const SOURCE_COURSE_SLUG = 'sexual-harassment-e';
    private const TARGET_EMPLOYEE_COURSE_SLUG = 'sexual-harassment-illinois';
    private const TARGET_MANAGER_COURSE_SLUG = 'sexual-harassment-illinois-m';
    private const TARGET_STATES = ['illinois', 'il'];
    private const MANAGER_ROLE_NAMES = ['Owner', 'GM', 'CFO', 'GSM', 'Manager'];
    private const EMPLOYEE_ROLE_NAMES = ['Employee', 'Porter/Driver'];
    private const NORMALIZED_MANAGER_ROLE_NAMES = ['owner', 'gm', 'cfo', 'gsm', 'manager'];
    private const NORMALIZED_EMPLOYEE_ROLE_NAMES = ['employee', 'porterdriver'];

    protected $signature = 'courses:backfill-illinois-harassment-results
        {--tenant= : Tenant ID to run against}
        {--email= : Limit run to a specific user email}
        {--dry-run : Preview without writing course results}';
    protected $description = 'Backfill Illinois harassment course results from passed sexual-harassment-e results';

    public function handle(): int
    {
        $tenantId = $this->option('tenant');
        $email = $this->option('email');
        $dryRun = (bool) $this->option('dry-run');
        $emailFilter = is_string($email) && trim($email) !== '' ? mb_strtolower(trim($email)) : null;

        $tenants = Dealership::query()
            ->when(
                is_string($tenantId) && $tenantId !== '',
                fn (Builder $query): Builder => $query->where('id', $tenantId)
            )
            ->orderBy('id')
            ->get(['id', 'name']);

        if ($tenants->isEmpty()) {
            $this->error('No tenants found for this command run.');

            return self::FAILURE;
        }

        $overallCreated = 0;
        $overallSkippedNoSource = 0;
        $overallSkippedExisting = 0;
        $overallCandidateUsers = 0;
        $tenantIds = $tenants->pluck('id');

        tenancy()->runForMultiple($tenantIds->isEmpty() ? null : $tenantIds, function ($tenant) use (
            $dryRun,
            $emailFilter,
            &$overallCreated,
            &$overallSkippedNoSource,
            &$overallSkippedExisting,
            &$overallCandidateUsers
        ): void {
            /** @var Dealership $tenant */
            $stats = $this->processTenant($dryRun, $emailFilter);

            if (isset($stats['error'])) {
                $this->warn("{$tenant->id}: {$stats['error']}");

                return;
            }

            $overallCreated += $stats['created'];
            $overallSkippedNoSource += $stats['skipped_no_source_result'];
            $overallSkippedExisting += $stats['skipped_existing_target_result'];
            $overallCandidateUsers += $stats['candidate_users'];

            $this->line(
                "{$tenant->id}: candidate={$stats['candidate_users']}, ".
                "created={$stats['created']}, ".
                "skipped_no_source={$stats['skipped_no_source_result']}, ".
                "skipped_existing={$stats['skipped_existing_target_result']}"
            );

            if ($dryRun && $stats['would_create'] !== []) {
                foreach ($stats['would_create'] as $row) {
                    $this->line(
                        "  would_create: user_id={$row['user_id']}, ".
                        "email={$row['email']}, ".
                        "source_result_id={$row['source_result_id']}, ".
                        "target_course_slug={$row['target_course_slug']}, ".
                        "percentage={$row['percentage']}, ".
                        "passed={$row['passed']}"
                    );
                }
            }

            if ($dryRun && $stats['skipped_details'] !== []) {
                foreach ($stats['skipped_details'] as $row) {
                    $this->line(
                        "  skipped: user_id={$row['user_id']}, ".
                        "email={$row['email']}, ".
                        "reason={$row['reason']}"
                    );
                }
            }
        });

        $prefix = $dryRun ? '[dry-run] ' : '';
        $this->info(
            "{$prefix}Done. candidate={$overallCandidateUsers}, ".
            "created={$overallCreated}, ".
            "skipped_no_source={$overallSkippedNoSource}, ".
            "skipped_existing={$overallSkippedExisting}"
        );

        return self::SUCCESS;
    }

    /**
     * @return array{
     *   candidate_users:int,
     *   created:int,
     *   skipped_no_source_result:int,
     *   skipped_existing_target_result:int,
     *   would_create: array<int, array{
     *      user_id:int,
     *      email:string,
     *      source_result_id:int,
     *      target_course_slug:string,
     *      percentage:int,
     *      passed:int|bool
     *   }>,
     *   skipped_details: array<int, array{
     *      user_id:int,
     *      email:string,
     *      reason:string
     *   }>
     * }|array{error:string}
     */
    private function processTenant(bool $dryRun, ?string $emailFilter = null): array
    {
        $targetCourses = Course::query()
            ->whereIn('slug', [self::TARGET_EMPLOYEE_COURSE_SLUG, self::TARGET_MANAGER_COURSE_SLUG])
            ->get()
            ->keyBy('slug');
        $sourceCourseExists = Course::query()->where('slug', self::SOURCE_COURSE_SLUG)->exists();

        if (! $sourceCourseExists
            || ! $targetCourses->has(self::TARGET_EMPLOYEE_COURSE_SLUG)
            || ! $targetCourses->has(self::TARGET_MANAGER_COURSE_SLUG)) {
            return [
                'error' => 'Missing source or target course slug in tenant.',
            ];
        }

        $candidateUsers = User::query()
            ->whereHas('stores', function (Builder $query): void {
                $query->whereRaw('LOWER(TRIM(state)) IN (?, ?)', self::TARGET_STATES);
            })
            ->whereHas('roles', function (Builder $query): void {
                $query->whereIn('name', [...self::MANAGER_ROLE_NAMES, ...self::EMPLOYEE_ROLE_NAMES])
                    ->orWhereRaw(
                        "REPLACE(REPLACE(LOWER(TRIM(name)), ' ', ''), '/', '') IN (?, ?, ?, ?, ?, ?, ?)",
                        [...self::NORMALIZED_MANAGER_ROLE_NAMES, ...self::NORMALIZED_EMPLOYEE_ROLE_NAMES]
                    );
            })
            ->when($emailFilter !== null, function (Builder $query) use ($emailFilter): void {
                $query->whereRaw('LOWER(email) = ?', [$emailFilter]);
            })
            ->with('roles:id,name')
            ->get(['id', 'email']);

        $created = 0;
        $skippedNoSourceResult = 0;
        $skippedExistingTargetResult = 0;
        $wouldCreate = [];
        $skippedDetails = [];

        foreach ($candidateUsers as $user) {
            $targetCourseSlug = $this->resolveTargetCourseSlugForUser($user);

            if ($targetCourseSlug === null) {
                continue;
            }

            /** @var Course $targetCourse */
            $targetCourse = $targetCourses->get($targetCourseSlug);

            $sourceResult = CourseResults::query()
                ->where('user_id', $user->id)
                ->where('passed', true)
                ->whereHas('course', function (Builder $query): void {
                    $query->where('slug', self::SOURCE_COURSE_SLUG);
                })
                ->orderByDesc('updated_at')
                ->orderByDesc('id')
                ->first();

            if (! $sourceResult) {
                $skippedNoSourceResult++;
                if ($dryRun && $emailFilter !== null) {
                    $skippedDetails[] = [
                        'user_id' => $user->id,
                        'email' => (string) $user->email,
                        'reason' => 'no_passed_source_result_for_sexual-harassment-e',
                    ];
                }

                continue;
            }

            $targetResultExists = CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function (Builder $query): void {
                    $query->whereIn('slug', [self::TARGET_EMPLOYEE_COURSE_SLUG, self::TARGET_MANAGER_COURSE_SLUG]);
                })
                ->exists();

            if ($targetResultExists) {
                $skippedExistingTargetResult++;
                if ($dryRun && $emailFilter !== null) {
                    $skippedDetails[] = [
                        'user_id' => $user->id,
                        'email' => (string) $user->email,
                        'reason' => 'existing_target_result',
                    ];
                }

                continue;
            }

            if ($dryRun) {
                $wouldCreate[] = [
                    'user_id' => $user->id,
                    'email' => (string) $user->email,
                    'source_result_id' => $sourceResult->id,
                    'target_course_slug' => $targetCourseSlug,
                    'percentage' => $sourceResult->percentage,
                    'passed' => $sourceResult->passed,
                ];
            }

            if (! $dryRun) {
                CourseResults::query()->create([
                    'percentage' => $sourceResult->percentage,
                    'passed' => $sourceResult->passed,
                    'course_id' => $targetCourse->id,
                    'user_id' => $sourceResult->user_id,
                    'created_at' => $sourceResult->created_at,
                    'updated_at' => $sourceResult->updated_at,
                ]);
            }

            $created++;
        }

        return [
            'candidate_users' => $candidateUsers->count(),
            'created' => $created,
            'skipped_no_source_result' => $skippedNoSourceResult,
            'skipped_existing_target_result' => $skippedExistingTargetResult,
            'would_create' => $wouldCreate,
            'skipped_details' => $skippedDetails,
        ];
    }

    private function resolveTargetCourseSlugForUser(User $user): ?string
    {
        $normalizedRoleNames = $user->roles
            ->pluck('name')
            ->map(fn (string $name): string => $this->normalizeRoleName($name))
            ->all();

        if (array_intersect(self::NORMALIZED_MANAGER_ROLE_NAMES, $normalizedRoleNames) !== []) {
            return self::TARGET_MANAGER_COURSE_SLUG;
        }

        if (array_intersect(self::NORMALIZED_EMPLOYEE_ROLE_NAMES, $normalizedRoleNames) !== []) {
            return self::TARGET_EMPLOYEE_COURSE_SLUG;
        }

        return null;
    }

    private function normalizeRoleName(string $name): string
    {
        return str_replace([' ', '/'], '', mb_strtolower(trim($name)));
    }
}
