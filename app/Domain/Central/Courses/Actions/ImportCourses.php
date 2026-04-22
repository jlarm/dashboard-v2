<?php

declare(strict_types=1);

namespace App\Domain\Central\Courses\Actions;

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealership;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class ImportCourses
{
    /**
     * @return array{created:int,updated:int}
     */
    public function handle(UploadedFile $file): array
    {
        $courses = $this->parsePayload($file);
        $courses = $this->resolveRoleNames($courses);
        $stats = $this->upsertCentralCourses($courses);

        tenancy()->central(function () use ($courses): void {
            Dealership::query()->chunkById(50, function (Collection $tenants) use ($courses): void {
                foreach ($tenants as $tenant) {
                    /** @var Dealership $tenant */
                    tenancy()->initialize($tenant);
                    $this->upsertTenantCourses($courses);
                    tenancy()->end();
                }
            });
        });

        return $stats;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function parsePayload(UploadedFile $file): array
    {
        $content = file_get_contents($file->getRealPath());
        $decoded = json_decode((string) $content, true);

        throw_unless(is_array($decoded), ValidationException::withMessages([
            'file' => 'The uploaded JSON must contain an array of courses.',
        ]));

        $courses = [];

        foreach ($decoded as $index => $course) {
            $validator = Validator::make($course, [
                'slug' => ['required', 'string'],
                'name' => ['required', 'string'],
                'slides' => ['present', 'array'],
                'questions' => ['nullable', 'array'],
                'video_id' => ['nullable', 'string'],
                'optional' => ['nullable', 'boolean'],
                'years_expires' => ['nullable', 'integer', 'min:1'],
                'department' => ['nullable', 'array'],
                'department.*' => ['integer'],
                'roles' => ['nullable', 'array'],
                'roles.*' => ['integer'],
                'states_required' => ['nullable', 'array'],
                'states_required.*' => ['string'],
                'replaces_course_slugs' => ['nullable', 'array'],
                'replaces_course_slugs.*' => ['string'],
            ]);

            throw_if($validator->fails(), ValidationException::withMessages([
                'file' => "Course entry #{$index} is invalid: ".$validator->errors()->first(),
            ]));

            $states = collect($course['states_required'] ?? [])
                ->filter(fn ($state): bool => is_string($state) && $state !== '')
                ->values()
                ->all();

            $replaces = collect($course['replaces_course_slugs'] ?? [])
                ->filter(fn ($slug): bool => is_string($slug) && $slug !== '')
                ->values()
                ->all();

            $courses[] = [
                'slug' => $course['slug'],
                'name' => $course['name'],
                'slides' => $course['slides'],
                'questions' => $course['questions'] ?? [],
                'video_id' => $course['video_id'] ?? null,
                'optional' => (bool) ($course['optional'] ?? false),
                'years_expires' => $course['years_expires'] ?? null,
                'department' => array_values($course['department'] ?? []),
                'roles' => array_values($course['roles'] ?? []),
                'states_required' => $states === [] ? null : $states,
                'replaces_course_slugs' => $replaces === [] ? null : $replaces,
            ];
        }

        return $courses;
    }

    /**
     * Role IDs differ per tenant, so collapse them to names and re-resolve per tenant below.
     *
     * @param  array<int, array<string, mixed>>  $courses
     * @return array<int, array<string, mixed>>
     */
    private function resolveRoleNames(array $courses): array
    {
        $allRoleIds = collect($courses)
            ->pluck('roles')
            ->flatten()
            ->unique()
            ->filter()
            ->values()
            ->toArray();

        $roleNamesById = Role::query()
            ->whereIn('id', $allRoleIds)
            ->pluck('name', 'id');

        foreach ($courses as &$course) {
            $course['role_names'] = collect($course['roles'])
                ->map(fn (int $id): ?string => $roleNamesById->get($id))
                ->filter()
                ->values()
                ->all();
        }

        return $courses;
    }

    /**
     * @param  array<int, array<string, mixed>>  $courses
     * @return array{created:int,updated:int}
     */
    private function upsertCentralCourses(array $courses): array
    {
        $created = 0;
        $updated = 0;

        foreach ($courses as $course) {
            $central = Course::query()->updateOrCreate(
                ['slug' => $course['slug']],
                [
                    'name' => $course['name'],
                    'slides' => $course['slides'],
                    'questions' => $course['questions'],
                    'video_id' => $course['video_id'],
                    'states_required' => $course['states_required'],
                    'replaces_course_slugs' => $course['replaces_course_slugs'],
                ]
            );

            $central->departments()->sync($course['department']);

            $central->wasRecentlyCreated ? $created++ : $updated++;
        }

        return ['created' => $created, 'updated' => $updated];
    }

    /**
     * @param  array<int, array<string, mixed>>  $courses
     */
    private function upsertTenantCourses(array $courses): void
    {
        foreach ($courses as $course) {
            $tenantCourse = TenantCourse::query()->updateOrCreate(
                ['slug' => $course['slug']],
                [
                    'name' => $course['name'],
                    'slides' => $course['slides'],
                    'questions' => $course['questions'],
                    'optional' => $course['optional'],
                    'video_id' => $course['video_id'],
                    'years_expires' => $course['years_expires'],
                    'states_required' => $course['states_required'],
                    'replaces_course_slugs' => $course['replaces_course_slugs'],
                ]
            );

            $tenantCourse->departments()->sync($course['department']);

            $tenantRoleIds = Role::query()
                ->whereIn('name', $course['role_names'])
                ->pluck('id')
                ->toArray();

            $tenantCourse->roles()->sync($tenantRoleIds);
        }
    }
}
