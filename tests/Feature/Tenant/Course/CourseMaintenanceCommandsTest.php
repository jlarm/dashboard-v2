<?php

declare(strict_types=1);

use App\Models\Dealer\Course as TenantCourse;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function (): void {
    Carbon::setTestNow('2026-06-15 12:00:00');
});

afterEach(function (): void {
    Carbon::setTestNow();
});

describe('courses:revert-reset', function (): void {
    it('restores soft-deleted CourseResults for the given tenant', function (): void {
        $store = Store::query()->firstOrFail();
        $user = User::query()->create([
            'name' => 'Pat',
            'email' => 'pat-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);
        $course = TenantCourse::query()->create([
            'slug' => 'revert-test',
            'name' => 'Revert Test',
            'slides' => [],
            'questions' => [],
        ]);

        $result = CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => 1,
            'percentage' => 100,
        ]);
        $result->delete();

        expect(CourseResults::onlyTrashed()->count())->toBe(1);

        tenancy()->end();
        $this->artisan('courses:revert-reset', ['tenant' => $this->tenant->id])
            ->expectsOutputToContain('Successfully restored 1 course results')
            ->assertSuccessful();

        $this->tenant->run(function (): void {
            expect(CourseResults::query()->count())->toBe(1);
            expect(CourseResults::onlyTrashed()->count())->toBe(0);
        });
    });

    it('reports "No course results to restore" when nothing is soft-deleted', function (): void {
        tenancy()->end();
        $this->artisan('courses:revert-reset', ['tenant' => $this->tenant->id])
            ->expectsOutputToContain('No course results to restore')
            ->assertSuccessful();
    });

    it('errors gracefully for an unknown tenant UUID', function (): void {
        tenancy()->end();
        $this->artisan('courses:revert-reset', ['tenant' => 'not-a-real-tenant'])
            ->expectsOutputToContain('not found')
            ->assertSuccessful();
    });
});

describe('courses:update-optional', function (): void {
    it('flags the configured course slugs as optional in the tenant database', function (): void {
        // Target slugs the command marks optional
        $target = TenantCourse::query()->create([
            'slug' => 'tractor-safety',
            'name' => 'Tractor Safety',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $alsoTarget = TenantCourse::query()->create([
            'slug' => 'powered-industrial-trucks',
            'name' => 'Powered Industrial Trucks',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        $untouched = TenantCourse::query()->create([
            'slug' => 'mandatory-course',
            'name' => 'Mandatory',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        tenancy()->end();
        $this->artisan('courses:update-optional', ['--tenants' => [$this->tenant->id]])
            ->assertSuccessful();

        $this->tenant->run(function () use ($target, $alsoTarget, $untouched): void {
            expect((bool) $target->fresh()->optional)->toBeTrue();
            expect((bool) $alsoTarget->fresh()->optional)->toBeTrue();
            expect((bool) $untouched->fresh()->optional)->toBeFalse();
        });
    });
});

describe('courses:add-video', function (): void {
    it('sets the video_id on the matching course in the tenant database', function (): void {
        $course = TenantCourse::query()->create([
            'slug' => 'safety-101',
            'name' => 'Safety 101',
            'slides' => [],
            'questions' => [],
            'video_id' => null,
        ]);

        tenancy()->end();
        $this->artisan('courses:add-video', [
            'slug' => 'safety-101',
            'video_id' => 'vimeo-12345',
            '--tenants' => [$this->tenant->id],
        ])
            ->expectsOutputToContain("Successfully updated course 'Safety 101'")
            ->assertSuccessful();

        $this->tenant->run(function () use ($course): void {
            expect($course->fresh()->video_id)->toBe('vimeo-12345');
        });
    });

    it('reports an error and leaves data alone when no course matches the slug', function (): void {
        $existing = TenantCourse::query()->create([
            'slug' => 'kept-course',
            'name' => 'Kept',
            'slides' => [],
            'questions' => [],
            'video_id' => 'original-video',
        ]);

        tenancy()->end();
        $this->artisan('courses:add-video', [
            'slug' => 'does-not-exist',
            'video_id' => 'wont-be-applied',
            '--tenants' => [$this->tenant->id],
        ])
            ->expectsOutputToContain("Course with slug 'does-not-exist' not found")
            ->assertSuccessful();

        $this->tenant->run(function () use ($existing): void {
            expect($existing->fresh()->video_id)->toBe('original-video');
        });
    });
});
