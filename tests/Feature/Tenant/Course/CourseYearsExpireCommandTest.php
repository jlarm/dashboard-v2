<?php

declare(strict_types=1);

use App\Models\Dealer\Course as TenantCourse;

it('sets years_expires=1 by default for any non-custom course slug', function (): void {
    $course = TenantCourse::query()->create([
        'slug' => 'general-safety',
        'name' => 'General Safety',
        'slides' => [],
        'questions' => [],
        'years_expires' => null,
    ]);

    tenancy()->end();
    $this->artisan('courses:years-expire', ['--tenants' => [$this->tenant->id]])->assertExitCode(0);

    $this->tenant->run(function () use ($course): void {
        expect((int) $course->fresh()->years_expires)->toBe(1);
    });
});

it('uses years_expires=3 for the four DOT hazardous-materials course slugs', function (): void {
    $hazmatSlugs = [
        'dot-hazardous-materials-transportation',
        'dot-hazardous-materials-transportation-identifying-hazardous-materials',
        'dot-hazardous-materials-transportation-preparing-hazardous-materials-for-shipment',
        'dot-hazardous-materials-transportation-shipping-papers-emergency-response-and-placarding',
    ];

    $courses = collect($hazmatSlugs)->map(fn (string $slug): TenantCourse => TenantCourse::query()->create([
        'slug' => $slug,
        'name' => 'DOT Hazmat course',
        'slides' => [],
        'questions' => [],
        'years_expires' => null,
    ]));

    tenancy()->end();
    $this->artisan('courses:years-expire', ['--tenants' => [$this->tenant->id]])->assertExitCode(0);

    $this->tenant->run(function () use ($courses): void {
        foreach ($courses as $course) {
            expect((int) $course->fresh()->years_expires)->toBe(3);
        }
    });
});

it('overrides existing years_expires values with the configured ones', function (): void {
    $course = TenantCourse::query()->create([
        'slug' => 'general-safety',
        'name' => 'General Safety',
        'slides' => [],
        'questions' => [],
        'years_expires' => 5,
    ]);

    tenancy()->end();
    $this->artisan('courses:years-expire', ['--tenants' => [$this->tenant->id]])->assertExitCode(0);

    $this->tenant->run(function () use ($course): void {
        expect((int) $course->fresh()->years_expires)->toBe(1);
    });
});
