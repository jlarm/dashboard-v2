<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

describe('central course management index', function (): void {
    it('renders the index page for super admins', function (): void {
        Course::query()->create([
            'name' => '!AAA Listed Course',
            'slug' => 'listed-course-'.uniqid(),
            'slides' => [],
            'questions' => [],
        ]);

        asSuperAdmin();

        $this->get(route('course-management.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/course-management/Index')
                ->has('courses.data')
                ->where('courses.data', fn ($courses) => collect($courses)->contains(fn ($course) => $course['name'] === '!AAA Listed Course'))
            );
    });

    it('forbids non super-admin users', function (): void {
        asConsultant();

        $this->get(route('course-management.index'))->assertForbidden();
    });
});

describe('central course management import', function (): void {
    it('allows importing a course with empty slides', function (): void {
        asSuperAdmin();

        $json = json_encode([
            [
                'name' => 'Imported Empty Slides Course',
                'slug' => 'imported-empty-slides-course',
                'department' => [],
                'roles' => [],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('course-empty-slides.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $course = Course::query()->where('slug', 'imported-empty-slides-course')->firstOrFail();

        expect($course->slides)->toBe([]);
    });

    it('imports a course from json with state replacement fields', function (): void {
        asSuperAdmin();

        $json = json_encode([
            [
                'name' => 'Imported California Course',
                'slug' => 'imported-california-course',
                'department' => [],
                'roles' => [],
                'states_required' => ['California'],
                'replaces_course_slugs' => ['sexual-harassment-e', 'sexual-harassment-m'],
                'slides' => [
                    [
                        'title' => 'Slide 1',
                        'description' => 'Course content',
                    ],
                ],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('course-import.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $course = Course::query()->where('slug', 'imported-california-course')->firstOrFail();

        expect($course->states_required)->toBe(['California'])
            ->and($course->replaces_course_slugs)->toBe(['sexual-harassment-e', 'sexual-harassment-m']);
    });

    it('syncs roles to tenants by name rather than raw ID', function (): void {
        asSuperAdmin();

        [$tenant] = createDealershipTenant();

        $centralEmployeeRoleId = Role::query()->where('name', 'Employee')->value('id');

        $json = json_encode([
            [
                'name' => 'Role Sync Test Course',
                'slug' => 'role-sync-test-course',
                'department' => [],
                'roles' => [$centralEmployeeRoleId],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('role-sync.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $tenant->run(function (): void {
            $course = TenantCourse::query()->where('slug', 'role-sync-test-course')->firstOrFail();
            $tenantEmployeeRoleId = Role::query()->where('name', 'Employee')->value('id');

            expect($course->roles()->pluck('id')->toArray())->toContain($tenantEmployeeRoleId);
        });

        teardownTenants();
    });

    it('updates an existing course when the imported slug already exists', function (): void {
        asSuperAdmin();

        Course::query()->create([
            'name' => 'Original Course',
            'slug' => 'existing-import-course',
            'slides' => [
                [
                    'title' => 'Old Slide',
                    'description' => 'Old Content',
                ],
            ],
            'questions' => [],
        ]);

        $json = json_encode([
            [
                'name' => 'Updated Import Course',
                'slug' => 'existing-import-course',
                'department' => [],
                'roles' => [],
                'states_required' => ['California'],
                'replaces_course_slugs' => ['general-harassment'],
                'slides' => [
                    [
                        'title' => 'Updated Slide',
                        'description' => 'Updated content',
                    ],
                ],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('course-update.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $course = Course::query()->where('slug', 'existing-import-course')->firstOrFail();

        expect($course->name)->toBe('Updated Import Course')
            ->and($course->slides[0]['title'])->toBe('Updated Slide')
            ->and($course->states_required)->toBe(['California'])
            ->and($course->replaces_course_slugs)->toBe(['general-harassment']);
    });
});
