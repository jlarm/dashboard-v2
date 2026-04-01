<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    [$this->tenant, $this->consultant] = createDealershipTenant();
});

afterEach(function (): void {
    teardownTenants();
});

it('backfills illinois course results from passed sexual-harassment-e results', function (): void {
    $sourceTimestamp = Carbon::parse('2026-01-10 09:15:00');

    $this->tenant->run(function () use ($sourceTimestamp): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois Store',
            'slug' => 'illinois-store',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'Illinois Employee',
            'email' => 'illinois-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole('Employee');

        CourseResults::query()->create([
            'percentage' => 92,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
            'created_at' => $sourceTimestamp,
            'updated_at' => $sourceTimestamp,
        ]);

        expect(
            CourseResults::query()
                ->where('course_id', $sourceCourse->id)
                ->where('user_id', $user->id)
                ->where('passed', true)
                ->exists()
        )->toBeTrue();

        expect(
            CourseResults::query()
                ->where('course_id', $targetCourse->id)
                ->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1');

    $this->tenant->run(function () use ($sourceTimestamp): void {
        $user = User::query()->where('email', 'illinois-employee@example.com')->firstOrFail();

        $sourceResult = CourseResults::query()
            ->where('user_id', $user->id)
            ->whereHas('course', function ($query): void {
                $query->where('slug', 'sexual-harassment-e');
            })
            ->firstOrFail();

        $targetResults = CourseResults::query()
            ->where('user_id', $user->id)
            ->whereHas('course', function ($query): void {
                $query->where('slug', 'sexual-harassment-illinois');
            })
            ->get();

        expect($targetResults)->toHaveCount(1);

        $targetResult = $targetResults->first();
        expect($targetResult)->not->toBeNull()
            ->and($targetResult->user_id)->toBe($user->id);

        expect($targetResult->passed)->toBe(1)
            ->and($targetResult->percentage)->toBe($sourceResult->percentage)
            ->and($targetResult->created_at->toDateTimeString())->toBe($sourceTimestamp->toDateTimeString())
            ->and($targetResult->updated_at->toDateTimeString())->toBe($sourceTimestamp->toDateTimeString());
    });
});

it('backfills manager role users into sexual-harassment-illinois-m', function (): void {
    $this->tenant->run(function (): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetManagerCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois Store Manager',
            'slug' => 'illinois-store-manager',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Manager']);

        $user = User::query()->create([
            'name' => 'Illinois Manager',
            'email' => 'illinois-manager@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole('Manager');

        CourseResults::query()->create([
            'percentage' => 88,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);

        expect(
            CourseResults::query()
                ->where('course_id', $targetManagerCourse->id)
                ->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'illinois-manager@example.com')->firstOrFail();

        expect(
            CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function ($query): void {
                    $query->where('slug', 'sexual-harassment-illinois-m');
                })
                ->count()
        )->toBe(1);

        expect(
            CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function ($query): void {
                    $query->where('slug', 'sexual-harassment-illinois');
                })
                ->count()
        )->toBe(0);
    });
});

it('backfills porter-driver users into sexual-harassment-illinois', function (): void {
    $this->tenant->run(function (): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetEmployeeCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois Store Porter',
            'slug' => 'illinois-store-porter',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Porter/Driver']);

        $user = User::query()->create([
            'name' => 'Illinois Porter',
            'email' => 'illinois-porter@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole('Porter/Driver');

        CourseResults::query()->create([
            'percentage' => 90,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);

        expect(
            CourseResults::query()
                ->where('course_id', $targetEmployeeCourse->id)
                ->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'illinois-porter@example.com')->firstOrFail();

        expect(
            CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function ($query): void {
                    $query->where('slug', 'sexual-harassment-illinois');
                })
                ->count()
        )->toBe(1);
    });
});

it('skips users whose stores are not in illinois', function (): void {
    $this->tenant->run(function (): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetEmployeeCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetManagerCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $texasStore = Store::query()->create([
            'name' => 'Texas Store',
            'slug' => 'texas-store',
            'state' => 'Texas',
        ]);

        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'Texas Employee',
            'email' => 'texas-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($texasStore->id);
        $user->assignRole('Employee');

        CourseResults::query()->create([
            'percentage' => 100,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);

        expect(
            CourseResults::query()->where('course_id', $targetEmployeeCourse->id)->count()
        )->toBe(0);

        expect(
            CourseResults::query()->where('course_id', $targetManagerCourse->id)->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=0')
        ->and($output)->toContain('created=0');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'texas-employee@example.com')->firstOrFail();

        expect(
            CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function ($query): void {
                    $query->whereIn('slug', ['sexual-harassment-illinois', 'sexual-harassment-illinois-m']);
                })
                ->count()
        )->toBe(0);
    });
});

it('includes users whose store state is IL abbreviation', function (): void {
    $this->tenant->run(function (): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetEmployeeCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $ilStore = Store::query()->create([
            'name' => 'IL Store',
            'slug' => 'il-store',
            'state' => 'IL',
        ]);

        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'IL Employee',
            'email' => 'il-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($ilStore->id);
        $user->assignRole('Employee');

        CourseResults::query()->create([
            'percentage' => 100,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);

        expect(
            CourseResults::query()->where('course_id', $targetEmployeeCourse->id)->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'il-employee@example.com')->firstOrFail();

        expect(
            CourseResults::query()
                ->where('user_id', $user->id)
                ->whereHas('course', function ($query): void {
                    $query->where('slug', 'sexual-harassment-illinois');
                })
                ->count()
        )->toBe(1);
    });
});

it('does not write records during dry-run', function (): void {
    $this->tenant->run(function (): void {
        $sourceCourse = Course::query()->create([
            'name' => 'Sexual Harassment Explained',
            'slug' => 'sexual-harassment-e',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $targetCourse = Course::query()->create([
            'name' => 'Illinois Sexual Harassment',
            'slug' => 'sexual-harassment-illinois',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);
        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois Store 2',
            'slug' => 'illinois-store-2',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'Dry Run Employee',
            'email' => 'dry-run-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole('Employee');

        CourseResults::query()->create([
            'percentage' => 100,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);

        expect(
            CourseResults::query()
                ->where('course_id', $targetCourse->id)
                ->count()
        )->toBe(0);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
        '--dry-run' => true,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1')
        ->and($output)->toContain('would_create:')
        ->and($output)->toContain('dry-run-employee@example.com')
        ->and($output)->toContain('target_course_slug=sexual-harassment-illinois')
        ->and($output)->toContain('[dry-run]');

    $this->tenant->run(function (): void {
        expect(
            CourseResults::query()
                ->whereHas('course', function ($query): void {
                    $query->where('slug', 'sexual-harassment-illinois');
                })
                ->count()
        )->toBe(0);
    });
});
