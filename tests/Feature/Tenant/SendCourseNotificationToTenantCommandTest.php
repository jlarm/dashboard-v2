<?php

declare(strict_types=1);

use App\Mail\CourseNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function Pest\Laravel\artisan;

it('sends course notification email to all registered users', function (): void {
    Mail::fake();

    $user1 = User::query()->create([
        'name' => 'Test User 1',
        'email' => 'user1@test.com',
        'password' => bcrypt('password'),
    ]);

    $user2 = User::query()->create([
        'name' => 'Test User 2',
        'email' => 'user2@test.com',
        'password' => bcrypt('password'),
    ]);

    $courseLink = 'https://example.com/course/safety-training';

    artisan('course:send-notification', ['courseLink' => $courseLink])
        ->assertSuccessful();

    Mail::assertSent(CourseNotificationMail::class, fn ($mail): bool => $mail->hasTo($user1->email) && $mail->courseLink === $courseLink);

    Mail::assertSent(CourseNotificationMail::class, fn ($mail): bool => $mail->hasTo($user2->email) && $mail->courseLink === $courseLink);
});

it('does not send to soft-deleted users', function (): void {
    Mail::fake();

    $activeUser = User::query()->create([
        'name' => 'Active User',
        'email' => 'active@test.com',
        'password' => bcrypt('password'),
    ]);

    $deletedUser = User::query()->create([
        'name' => 'Deleted User',
        'email' => 'deleted@test.com',
        'password' => bcrypt('password'),
    ]);
    $deletedUser->delete();

    $courseLink = 'https://example.com/course/safety-training';

    artisan('course:send-notification', ['courseLink' => $courseLink])
        ->assertSuccessful();

    Mail::assertSent(CourseNotificationMail::class, fn ($mail) => $mail->hasTo($activeUser->email));

    Mail::assertNotSent(CourseNotificationMail::class, fn ($mail) => $mail->hasTo($deletedUser->email));
});

it('sends correct course link in email', function (): void {
    Mail::fake();

    $user = User::query()->create([
        'name' => 'Test User',
        'email' => 'user@test.com',
        'password' => bcrypt('password'),
    ]);

    $courseLink = 'https://example.com/course/specific-course-123';

    artisan('course:send-notification', ['courseLink' => $courseLink])
        ->assertSuccessful();

    Mail::assertSent(CourseNotificationMail::class, fn ($mail): bool => $mail->courseLink === $courseLink);
});

it('excludes super-admin and Consultant users', function (): void {
    Mail::fake();

    $regularUser = User::query()->create([
        'name' => 'Regular User',
        'email' => 'regular@test.com',
        'password' => bcrypt('password'),
    ]);

    $superAdmin = User::query()->create([
        'name' => 'Super Admin',
        'email' => 'superadmin@test.com',
        'password' => bcrypt('password'),
    ]);
    $superAdmin->assignRole('super-admin');

    $consultant = User::query()->create([
        'name' => 'Consultant User',
        'email' => 'consultant@test.com',
        'password' => bcrypt('password'),
    ]);
    $consultant->assignRole('Consultant');

    $courseLink = 'https://example.com/course/safety-training';

    artisan('course:send-notification', ['courseLink' => $courseLink])
        ->assertSuccessful();

    Mail::assertSent(CourseNotificationMail::class, fn ($mail) => $mail->hasTo($regularUser->email));
    Mail::assertNotSent(CourseNotificationMail::class, fn ($mail) => $mail->hasTo($superAdmin->email));
    Mail::assertNotSent(CourseNotificationMail::class, fn ($mail) => $mail->hasTo($consultant->email));
});
