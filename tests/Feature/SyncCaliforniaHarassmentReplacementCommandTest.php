<?php

declare(strict_types=1);

use App\Models\Course as CentralCourse;
use App\Models\Dealer\Course as TenantCourse;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    [$this->tenant, $this->consultant] = createDealershipTenant();

    CentralCourse::query()
        ->where('slug', 'sexual-harassment-training-in-california')
        ->delete();

    $this->tenant->run(function (): void {
        TenantCourse::query()
            ->where('slug', 'sexual-harassment-training-in-california')
            ->delete();
    });
});

afterEach(function (): void {
    teardownTenants();
});

it('updates california replacement fields in central and tenant', function (): void {
    CentralCourse::query()->create([
        'name' => 'CA Harassment',
        'slug' => 'sexual-harassment-training-in-california',
        'slides' => [],
        'questions' => [],
        'states_required' => null,
        'replaces_course_slugs' => null,
    ]);

    $this->tenant->run(function (): void {
        TenantCourse::query()->create([
            'name' => 'CA Harassment',
            'slug' => 'sexual-harassment-training-in-california',
            'slides' => [],
            'questions' => [],
            'optional' => false,
            'states_required' => null,
            'replaces_course_slugs' => null,
        ]);
    });

    $exitCode = Artisan::call('courses:sync-california-harassment-replacement', [
        '--tenant' => $this->tenant->id,
    ]);

    expect($exitCode)->toBe(0)
        ->and(Artisan::output())->toContain('updated_tenants=1');

    $centralCourse = CentralCourse::query()
        ->where('slug', 'sexual-harassment-training-in-california')
        ->firstOrFail();

    expect($centralCourse->states_required)->toBe(['California'])
        ->and($centralCourse->replaces_course_slugs)->toBe(['sexual-harassment-e', 'sexual-harassment-m']);

    $this->tenant->run(function (): void {
        $tenantCourse = TenantCourse::query()
            ->where('slug', 'sexual-harassment-training-in-california')
            ->firstOrFail();

        expect($tenantCourse->states_required)->toBe(['California'])
            ->and($tenantCourse->replaces_course_slugs)->toBe(['sexual-harassment-e', 'sexual-harassment-m']);
    });
});

it('does not persist changes in dry-run mode', function (): void {
    CentralCourse::query()->create([
        'name' => 'CA Harassment',
        'slug' => 'sexual-harassment-training-in-california',
        'slides' => [],
        'questions' => [],
        'states_required' => null,
        'replaces_course_slugs' => null,
    ]);

    $this->tenant->run(function (): void {
        TenantCourse::query()->create([
            'name' => 'CA Harassment',
            'slug' => 'sexual-harassment-training-in-california',
            'slides' => [],
            'questions' => [],
            'optional' => false,
            'states_required' => null,
            'replaces_course_slugs' => null,
        ]);
    });

    $exitCode = Artisan::call('courses:sync-california-harassment-replacement', [
        '--tenant' => $this->tenant->id,
        '--dry-run' => true,
    ]);

    expect($exitCode)->toBe(0)
        ->and(Artisan::output())->toContain('[dry-run] Done.');

    $centralCourse = CentralCourse::query()
        ->where('slug', 'sexual-harassment-training-in-california')
        ->firstOrFail();

    expect($centralCourse->states_required)->toBeNull()
        ->and($centralCourse->replaces_course_slugs)->toBeNull();

    $this->tenant->run(function (): void {
        $tenantCourse = TenantCourse::query()
            ->where('slug', 'sexual-harassment-training-in-california')
            ->firstOrFail();

        expect($tenantCourse->states_required)->toBeNull()
            ->and($tenantCourse->replaces_course_slugs)->toBeNull();
    });
});
