<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    [$this->tenant, $this->consultant] = createDealershipTenant();

    $this->tenant->run(function (): void {
        Course::query()->whereIn('slug', ['sexual-harassment-illinois', 'sexual-harassment-illinois-m'])
            ->get()
            ->each(fn (Course $course) => $course->roles()->detach());

        Course::query()->whereIn('slug', ['sexual-harassment-illinois', 'sexual-harassment-illinois-m'])->delete();
    });
});

afterEach(function (): void {
    teardownTenants();
});

it('assigns employee and porter/driver roles to the employee illinois course', function (): void {
    $this->tenant->run(function (): void {
        Course::query()->create(['name' => 'IL Harassment', 'slug' => 'sexual-harassment-illinois', 'slides' => [], 'optional' => false]);
        Course::query()->create(['name' => 'IL Harassment Manager', 'slug' => 'sexual-harassment-illinois-m', 'slides' => [], 'optional' => false]);
    });

    Artisan::call('courses:sync-illinois-harassment-roles', ['--tenant' => $this->tenant->id]);

    $this->tenant->run(function (): void {
        $course = Course::query()->where('slug', 'sexual-harassment-illinois')->with('roles')->first();
        $roleNames = $course->roles->pluck('name')->sort()->values()->all();

        expect($roleNames)->toBe(['Employee', 'Porter/Driver']);
    });
});

it('assigns manager roles to the manager illinois course', function (): void {
    $this->tenant->run(function (): void {
        Course::query()->create(['name' => 'IL Harassment', 'slug' => 'sexual-harassment-illinois', 'slides' => [], 'optional' => false]);
        Course::query()->create(['name' => 'IL Harassment Manager', 'slug' => 'sexual-harassment-illinois-m', 'slides' => [], 'optional' => false]);
    });

    Artisan::call('courses:sync-illinois-harassment-roles', ['--tenant' => $this->tenant->id]);

    $this->tenant->run(function (): void {
        $course = Course::query()->where('slug', 'sexual-harassment-illinois-m')->with('roles')->first();
        $roleNames = $course->roles->pluck('name')->sort()->values()->all();

        expect($roleNames)->toBe(['CFO', 'GM', 'GSM', 'Manager', 'Owner']);
    });
});

it('does not update roles in dry-run mode', function (): void {
    $this->tenant->run(function (): void {
        Course::query()->create(['name' => 'IL Harassment', 'slug' => 'sexual-harassment-illinois', 'slides' => [], 'optional' => false]);
        Course::query()->create(['name' => 'IL Harassment Manager', 'slug' => 'sexual-harassment-illinois-m', 'slides' => [], 'optional' => false]);
    });

    Artisan::call('courses:sync-illinois-harassment-roles', ['--tenant' => $this->tenant->id, '--dry-run' => true]);

    $this->tenant->run(function (): void {
        $course = Course::query()->where('slug', 'sexual-harassment-illinois')->with('roles')->first();

        expect($course->roles)->toBeEmpty();
    });
});

it('warns when illinois courses are missing for a tenant', function (): void {
    Artisan::call('courses:sync-illinois-harassment-roles', ['--tenant' => $this->tenant->id]);

    expect(Artisan::output())->toContain('one or both Illinois courses not found');
});
