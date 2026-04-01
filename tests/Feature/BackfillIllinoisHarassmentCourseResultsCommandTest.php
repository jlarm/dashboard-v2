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

it('includes users with role name variants for porter driver', function (): void {
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
            'name' => 'Illinois Role Variant Store',
            'slug' => 'illinois-role-variant-store',
            'state' => 'Illinois',
        ]);

        $role = Role::query()->create(['name' => ' porter / driver ']);

        $user = User::query()->create([
            'name' => 'Role Variant Employee',
            'email' => 'role-variant-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole($role);

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
        $user = User::query()->where('email', 'role-variant-employee@example.com')->firstOrFail();

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

it('shows skip reason for a specific filtered email in dry-run', function (): void {
    $this->tenant->run(function (): void {
        Course::query()->create([
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

        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois Missing Source Store',
            'slug' => 'illinois-missing-source-store',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'Missing Source Employee',
            'email' => 'missing-source-employee@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);
        $user->assignRole('Employee');
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
        '--dry-run' => true,
        '--email' => 'missing-source-employee@example.com',
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=0')
        ->and($output)->toContain('skipped_no_source=1')
        ->and($output)->toContain('missing-source-employee@example.com')
        ->and($output)->toContain('reason=no_passed_source_result_for_sexual-harassment-e');
});

it('is idempotent when run multiple times and does not create duplicate target results', function (): void {
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
            'name' => 'Illinois Idempotent Store',
            'slug' => 'illinois-idempotent-store',
            'state' => 'Illinois',
        ]);
        Role::query()->firstOrCreate(['name' => 'Employee']);

        $user = User::query()->create([
            'name' => 'Illinois Idempotent Employee',
            'email' => 'illinois-idempotent-employee@example.com',
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
                ->where('user_id', $user->id)
                ->count()
        )->toBe(0);
    });

    $firstExitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $firstOutput = Artisan::output();

    expect($firstExitCode)->toBe(0)
        ->and($firstOutput)->toContain('candidate=1')
        ->and($firstOutput)->toContain('created=1')
        ->and($firstOutput)->toContain('skipped_existing=0');

    $secondExitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $secondOutput = Artisan::output();

    expect($secondExitCode)->toBe(0)
        ->and($secondOutput)->toContain('candidate=1')
        ->and($secondOutput)->toContain('created=0')
        ->and($secondOutput)->toContain('skipped_existing=1');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'illinois-idempotent-employee@example.com')->firstOrFail();

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

it('backfills illinois users without mapped roles to sexual-harassment-illinois', function (): void {
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

        Course::query()->create([
            'name' => 'Illinois Sexual Harassment Manager',
            'slug' => 'sexual-harassment-illinois-m',
            'slides' => [],
            'questions' => [],
            'optional' => false,
        ]);

        $illinoisStore = Store::query()->create([
            'name' => 'Illinois No Role Store',
            'slug' => 'illinois-no-role-store',
            'state' => 'Illinois',
        ]);

        $user = User::query()->create([
            'name' => 'Illinois No Role User',
            'email' => 'illinois-no-role@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->stores()->attach($illinoisStore->id);

        CourseResults::query()->create([
            'percentage' => 90,
            'passed' => true,
            'course_id' => $sourceCourse->id,
            'user_id' => $user->id,
        ]);
    });

    $exitCode = Artisan::call('courses:backfill-illinois-harassment-results', [
        '--tenant' => $this->tenant->id,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('candidate=1')
        ->and($output)->toContain('created=1');

    $this->tenant->run(function (): void {
        $user = User::query()->where('email', 'illinois-no-role@example.com')->firstOrFail();

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
