<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
});

it('soft-deletes tenant course copies that are no longer assigned', function (): void {
    [$tenantA] = createDealershipTenant();
    [$tenantB] = createDealershipTenant();

    $central = Course::query()->create([
        'name' => 'Reconcile Soft Delete Course',
        'slug' => 'reconcile-soft-delete-course',
        'slides' => [],
        'questions' => [],
    ]);
    $central->tenants()->sync([$tenantA->id]);

    foreach ([$tenantA, $tenantB] as $tenant) {
        $tenant->run(function (): void {
            TenantCourse::query()->create([
                'slug' => 'reconcile-soft-delete-course',
                'name' => 'Reconcile Soft Delete Course',
                'slides' => [],
                'questions' => [],
            ]);
        });
    }

    $this->artisan('courses:reconcile-tenants', ['--force' => true])->assertSuccessful();

    $tenantA->run(function (): void {
        expect(TenantCourse::query()->where('slug', 'reconcile-soft-delete-course')->exists())->toBeTrue();
    });

    $tenantB->run(function (): void {
        expect(TenantCourse::query()->where('slug', 'reconcile-soft-delete-course')->exists())->toBeFalse();
        expect(TenantCourse::withTrashed()->where('slug', 'reconcile-soft-delete-course')->whereNotNull('deleted_at')->exists())->toBeTrue();
    });

    teardownTenants();
});

it('restores tenant course copies that have been re-assigned', function (): void {
    [$tenantA] = createDealershipTenant();

    $central = Course::query()->create([
        'name' => 'Reconcile Restore Course',
        'slug' => 'reconcile-restore-course',
        'slides' => [],
        'questions' => [],
    ]);
    $central->tenants()->sync([$tenantA->id]);

    $tenantA->run(function (): void {
        $course = TenantCourse::query()->create([
            'slug' => 'reconcile-restore-course',
            'name' => 'Reconcile Restore Course',
            'slides' => [],
            'questions' => [],
        ]);
        $course->delete();
    });

    $this->artisan('courses:reconcile-tenants', ['--force' => true])->assertSuccessful();

    $tenantA->run(function (): void {
        $course = TenantCourse::query()->where('slug', 'reconcile-restore-course')->first();
        expect($course)->not->toBeNull();
        expect($course->trashed())->toBeFalse();
    });

    teardownTenants();
});

it('does not modify tenant course copies in dry-run mode', function (): void {
    [$tenantA] = createDealershipTenant();
    [$tenantB] = createDealershipTenant();

    $central = Course::query()->create([
        'name' => 'Reconcile Dry Run Course',
        'slug' => 'reconcile-dry-run-course',
        'slides' => [],
        'questions' => [],
    ]);
    $central->tenants()->sync([$tenantA->id]);

    $tenantB->run(function (): void {
        TenantCourse::query()->create([
            'slug' => 'reconcile-dry-run-course',
            'name' => 'Reconcile Dry Run Course',
            'slides' => [],
            'questions' => [],
        ]);
    });

    $this->artisan('courses:reconcile-tenants')->assertSuccessful();

    $tenantB->run(function (): void {
        expect(TenantCourse::query()->where('slug', 'reconcile-dry-run-course')->exists())->toBeTrue();
    });

    teardownTenants();
});
