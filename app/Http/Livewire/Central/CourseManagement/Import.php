<?php

declare(strict_types=1);

namespace App\Http\Livewire\Central\CourseManagement;

use App\Models\Course;
use App\Models\Dealer\Course as DealerCourse;
use App\Models\Dealership;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\WithFileUploads;
use Throwable;
use WireElements\Pro\Components\Modal\Modal;

class Import extends Modal
{
    use WithFileUploads;

    public $courseImportFile;

    public function importCourses(): void
    {
        abort_unless(auth()->user()?->hasRole('super-admin'), 403);

        $this->validate([
            'courseImportFile' => ['required', 'file', 'extensions:json', 'max:5120'],
        ]);

        try {
            $courses = $this->parseCourseImportPayload();
            $importStats = $this->upsertCentralCourses($courses);

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

            Notification::make()
                ->title("Imported {$importStats['created']} course(s), updated {$importStats['updated']} course(s)")
                ->success()
                ->send();

            $this->emit('coursesImported');
            $this->close();
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);
            $this->addError('courseImportFile', 'Unable to import courses: '.$exception->getMessage());

            Notification::make()
                ->title('Unable to import courses')
                ->danger()
                ->send();
        }
    }

    public function render(): View
    {
        return view('livewire.central.course-management.import');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function parseCourseImportPayload(): array
    {
        $content = file_get_contents($this->courseImportFile->getRealPath());
        $decoded = json_decode($content, true);

        throw_unless(is_array($decoded), ValidationException::withMessages([
            'courseImportFile' => 'The uploaded JSON must contain an array of courses.',
        ]));

        $normalizedCourses = [];

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

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'courseImportFile' => "Course entry #{$index} is invalid: ".$validator->errors()->first(),
                ]);
            }

            $statesRequired = collect($course['states_required'] ?? [])
                ->filter(fn ($state): bool => is_string($state) && $state !== '')
                ->values()
                ->all();

            $replacesCourseSlugs = collect($course['replaces_course_slugs'] ?? [])
                ->filter(fn ($slug): bool => is_string($slug) && $slug !== '')
                ->values()
                ->all();

            $normalizedCourses[] = [
                'slug' => $course['slug'],
                'name' => $course['name'],
                'slides' => $course['slides'],
                'questions' => $course['questions'] ?? [],
                'video_id' => $course['video_id'] ?? null,
                'optional' => (bool) ($course['optional'] ?? false),
                'years_expires' => $course['years_expires'] ?? null,
                'department' => array_values($course['department'] ?? []),
                'roles' => array_values($course['roles'] ?? []),
                'states_required' => $statesRequired === [] ? null : $statesRequired,
                'replaces_course_slugs' => $replacesCourseSlugs === [] ? null : $replacesCourseSlugs,
            ];
        }

        return $normalizedCourses;
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
            $centralCourse = Course::query()->updateOrCreate(
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

            $centralCourse->departments()->sync($course['department']);

            if ($centralCourse->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        return [
            'created' => $created,
            'updated' => $updated,
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $courses
     */
    private function upsertTenantCourses(array $courses): void
    {
        foreach ($courses as $course) {
            $tenantCourse = DealerCourse::query()->updateOrCreate(
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
            $tenantCourse->roles()->sync($course['roles']);
        }
    }
}
