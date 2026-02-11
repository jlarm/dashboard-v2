<?php

declare(strict_types=1);

use App\Models\Dealer\Course;
use App\Models\Dealer\CourseResults;
use App\Models\Dealer\CourseUserNotificationSent;
use App\Models\Dealer\Store;
use App\Models\User;
use App\Notifications\ExpiredCourseNotification;
use App\Notifications\IncompleteCoursesNotification;
use App\Services\UserCourseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\artisan;

beforeEach(function (): void {
    app(UserCourseService::class)->clearAllCaches();

    // Ensure we have the basic roles
    Role::query()->firstOrCreate(['name' => 'Employee']);
    Role::query()->firstOrCreate(['name' => 'Manager']);
    Role::query()->firstOrCreate(['name' => 'Consultant']);
    Role::query()->firstOrCreate(['name' => 'super-admin']);
});

describe('EmployeeCourseReminderCommand', function (): void {
    it('sends notifications for courses expiring in 30 days', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Create a course result from exactly 335 days ago (365 - 30)
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subDays(335),
        ]);

        artisan('run:course-reminder')
            ->assertSuccessful();

        Notification::assertSentTo(
            $user,
            ExpiredCourseNotification::class,
            fn ($notification): bool => in_array($course->id, $notification->coursesGrouped['expiring_soon'])
        );
    });

    it('sends notifications for courses expiring today', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Create a course result from exactly 365 days ago
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subDays(365),
        ]);

        artisan('run:course-reminder')
            ->assertSuccessful();

        Notification::assertSentTo(
            $user,
            ExpiredCourseNotification::class,
            fn ($notification): bool => in_array($course->id, $notification->coursesGrouped['expired_today'])
        );
    });

    it('sends notifications for courses expired 30 days ago', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Create a course result from exactly 395 days ago (365 + 30)
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subDays(395),
        ]);

        artisan('run:course-reminder')
            ->assertSuccessful();

        Notification::assertSentTo(
            $user,
            ExpiredCourseNotification::class,
            fn ($notification): bool => in_array($course->id, $notification->coursesGrouped['expired_30_days'])
        );
    });

    it('only sends notifications for courses assigned to the user via UserCourseService', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $managerRole = Role::query()->where('name', 'Manager')->first();

        // Create a manager-only course
        $managerCourse = Course::query()->create([
            'name' => 'Manager Training',
            'slug' => 'manager-training',
            'slides' => [],
            'optional' => false,
        ]);
        $managerCourse->roles()->attach($managerRole->id);

        // Create an employee user
        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Create a course result for the manager course (which shouldn't be assigned to this employee)
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $managerCourse->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subDays(335),
        ]);

        artisan('run:course-reminder')
            ->assertSuccessful();

        // Should NOT receive notification because manager course is not assigned to employee
        Notification::assertNothingSentTo($user);
    });

    it('does not send duplicate notifications within 7 days', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subDays(335),
        ]);

        // Record that notification was sent 5 days ago
        CourseUserNotificationSent::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'sent' => Carbon::now()->subDays(5),
        ]);

        artisan('run:course-reminder')
            ->assertSuccessful();

        // Should NOT receive notification because one was sent within last 7 days
        Notification::assertNothingSentTo($user);
    });

    it('cleans up notifications older than 60 days', function (): void {
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);

        // Create old notification record
        CourseUserNotificationSent::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'sent' => Carbon::now()->subDays(65),
        ]);

        expect(CourseUserNotificationSent::query()->count())->toBe(1);

        artisan('run:course-reminder')
            ->assertSuccessful();

        // Old notification should be deleted
        expect(CourseUserNotificationSent::query()->count())->toBe(0);
    });
});

describe('CourseReminderCommand', function (): void {
    it('sends notification for users with incomplete courses when enabled', function (): void {
        Notification::fake();

        // Create store with notifications enabled
        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => true]);

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        artisan('course:reminder')
            ->assertSuccessful();

        Notification::assertSentTo($user, IncompleteCoursesNotification::class);
    });

    it('does not send notification if store has notifications disabled', function (): void {
        Notification::fake();

        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => false]);

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        artisan('course:reminder')
            ->assertSuccessful();

        Notification::assertNothingSentTo($user);
    });

    it('does not send notification if user has no incomplete courses', function (): void {
        Notification::fake();

        // Clear all seeded courses to avoid interference
        DB::table('course_role')->truncate();
        DB::table('course_department')->truncate();
        Course::query()->delete();

        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => true]);

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');
        $user->stores()->attach($store->id);

        // Attempt the course (even if failed, it counts as attempted/completed)
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'passed' => false,
            'percentage' => 50,
            'created_at' => Carbon::now(),
        ]);

        artisan('course:reminder')
            ->assertSuccessful();

        // Should NOT send notification because course was attempted (incomplete means not attempted at all)
        Notification::assertNothingSentTo($user);
    });

    it('respects 15-day interval between reminders', function (): void {
        Notification::fake();

        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => true]);

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
            'last_sent_course_reminder' => Carbon::now()->subDays(10),
        ]);
        $user->assignRole('Employee');

        artisan('course:reminder')
            ->assertSuccessful();

        // Should NOT receive notification because last reminder was sent 10 days ago
        Notification::assertNothingSentTo($user);
    });

    it('sends notification if more than 15 days since last reminder', function (): void {
        Notification::fake();

        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => true]);

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);
        $course->roles()->attach($employeeRole->id);

        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
            'last_sent_course_reminder' => Carbon::now()->subDays(20),
        ]);
        $user->assignRole('Employee');

        artisan('course:reminder')
            ->assertSuccessful();

        Notification::assertSentTo($user, IncompleteCoursesNotification::class);
    });

    it('excludes super-admin and Consultant users', function (): void {
        Notification::fake();

        $store = Store::query()->first();
        $store->update(['courses_not_taken_notification' => true]);

        $course = Course::query()->create([
            'name' => 'Safety Training',
            'slug' => 'safety-training',
            'slides' => [],
            'optional' => false,
        ]);

        $consultant = User::query()->create([
            'name' => 'Test Consultant',
            'email' => 'consultant@test.com',
            'password' => bcrypt('password'),
        ]);
        $consultant->assignRole('Consultant');

        artisan('course:reminder')
            ->assertSuccessful();

        Notification::assertNothingSentTo($consultant);
    });
});

describe('CourseExpiringEmailCommand', function (): void {
    it('uses UserCourseService to get assigned courses only', function (): void {
        Notification::fake();

        $employeeRole = Role::query()->where('name', 'Employee')->first();
        $managerRole = Role::query()->where('name', 'Manager')->first();

        // Create a manager-only course
        $managerCourse = Course::query()->create([
            'name' => 'Manager Training',
            'slug' => 'manager-training',
            'slides' => [],
            'optional' => false,
        ]);
        $managerCourse->roles()->attach($managerRole->id);

        // Create an employee user
        $user = User::query()->create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Employee');

        // Create a course result for the manager course (which shouldn't be assigned to this employee)
        // Set it to expire in 15 days
        CourseResults::query()->create([
            'user_id' => $user->id,
            'course_id' => $managerCourse->id,
            'passed' => true,
            'percentage' => 100,
            'created_at' => Carbon::now()->subYear()->addDays(15),
        ]);

        artisan('course:check-reminders')
            ->assertSuccessful();

        // Should NOT receive notification because manager course is not assigned to employee
        Notification::assertNothingSentTo($user);
    });
});
