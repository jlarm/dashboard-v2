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
                ->where('courses.data', fn ($courses) => collect($courses)->contains(fn ($course): bool => $course['name'] === '!AAA Listed Course'))
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

    it('imports a course only into tenants listed in tenants_required', function (): void {
        asSuperAdmin();

        [$tenantA] = createDealershipTenant();
        [$tenantB] = createDealershipTenant();

        $json = json_encode([
            [
                'name' => 'Tenant A Only Course',
                'slug' => 'tenant-a-only-course',
                'department' => [],
                'roles' => [],
                'tenants_required' => [$tenantA->id],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('tenant-restricted.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $centralCourse = Course::query()->where('slug', 'tenant-a-only-course')->firstOrFail();
        expect($centralCourse->tenants()->pluck('tenants.id')->all())->toBe([$tenantA->id]);

        $tenantA->run(function (): void {
            expect(TenantCourse::query()->where('slug', 'tenant-a-only-course')->exists())->toBeTrue();
        });

        $tenantB->run(function (): void {
            expect(TenantCourse::withTrashed()->where('slug', 'tenant-a-only-course')->exists())->toBeFalse();
        });

        teardownTenants();
    });

    it('imports an unrestricted course into every tenant', function (): void {
        asSuperAdmin();

        [$tenantA] = createDealershipTenant();
        [$tenantB] = createDealershipTenant();

        $json = json_encode([
            [
                'name' => 'Available To All Course',
                'slug' => 'available-to-all-course',
                'department' => [],
                'roles' => [],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('unrestricted.json', $json)],
        )->assertRedirect(route('course-management.index'));

        $tenantA->run(function (): void {
            expect(TenantCourse::query()->where('slug', 'available-to-all-course')->exists())->toBeTrue();
        });

        $tenantB->run(function (): void {
            expect(TenantCourse::query()->where('slug', 'available-to-all-course')->exists())->toBeTrue();
        });

        teardownTenants();
    });

    it('soft-deletes the tenant copy when re-importing with the tenant removed from tenants_required', function (): void {
        asSuperAdmin();

        [$tenantA] = createDealershipTenant();
        [$tenantB] = createDealershipTenant();

        $unrestrictedPayload = json_encode([
            [
                'name' => 'Soon-To-Be Restricted',
                'slug' => 'soon-restricted-course',
                'department' => [],
                'roles' => [],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('first.json', $unrestrictedPayload)],
        )->assertRedirect(route('course-management.index'));

        $tenantB->run(function (): void {
            expect(TenantCourse::query()->where('slug', 'soon-restricted-course')->exists())->toBeTrue();
        });

        $restrictedPayload = json_encode([
            [
                'name' => 'Soon-To-Be Restricted',
                'slug' => 'soon-restricted-course',
                'department' => [],
                'roles' => [],
                'tenants_required' => [$tenantA->id],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('second.json', $restrictedPayload)],
        )->assertRedirect(route('course-management.index'));

        $tenantB->run(function (): void {
            expect(TenantCourse::query()->where('slug', 'soon-restricted-course')->exists())->toBeFalse();
            expect(TenantCourse::withTrashed()->where('slug', 'soon-restricted-course')->whereNotNull('deleted_at')->exists())->toBeTrue();
        });

        teardownTenants();
    });

    it('restores a soft-deleted tenant copy when the tenant is re-added to tenants_required', function (): void {
        asSuperAdmin();

        [$tenantA] = createDealershipTenant();
        [$tenantB] = createDealershipTenant();

        $restrictedPayload = json_encode([
            [
                'name' => 'Reassign Test Course',
                'slug' => 'reassign-course',
                'department' => [],
                'roles' => [],
                'tenants_required' => [$tenantA->id],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('first.json', $restrictedPayload)],
        )->assertRedirect(route('course-management.index'));

        $tenantB->run(function (): void {
            $course = TenantCourse::query()->create([
                'slug' => 'reassign-course',
                'name' => 'Reassign Test Course',
                'slides' => [],
                'questions' => [],
            ]);
            $course->delete();
        });

        $reassignedPayload = json_encode([
            [
                'name' => 'Reassign Test Course',
                'slug' => 'reassign-course',
                'department' => [],
                'roles' => [],
                'tenants_required' => [$tenantA->id, $tenantB->id],
                'slides' => [],
                'questions' => [],
            ],
        ], JSON_THROW_ON_ERROR);

        $this->post(
            route('course-management.import'),
            ['file' => UploadedFile::fake()->createWithContent('second.json', $reassignedPayload)],
        )->assertRedirect(route('course-management.index'));

        $tenantB->run(function (): void {
            $course = TenantCourse::query()->where('slug', 'reassign-course')->first();
            expect($course)->not->toBeNull();
            expect($course->trashed())->toBeFalse();
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
