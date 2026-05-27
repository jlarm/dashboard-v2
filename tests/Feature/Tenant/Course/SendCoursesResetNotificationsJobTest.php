<?php

declare(strict_types=1);

use App\Jobs\SendCoursesResetNotifications;
use App\Mail\CourseResetNotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function (): void {
    Mail::fake();
});

it('queues a CourseResetNotificationMail to every user in the id collection', function (): void {
    $u1 = User::query()->create([
        'name' => 'User One', 'email' => 'one-'.uniqid().'@test-tenant.localhost', 'password' => bcrypt('x'),
    ]);
    $u2 = User::query()->create([
        'name' => 'User Two', 'email' => 'two-'.uniqid().'@test-tenant.localhost', 'password' => bcrypt('x'),
    ]);

    new SendCoursesResetNotifications(
        userIds: collect([$u1->id, $u2->id]),
        tenantName: 'Acme Auto',
    )->handle();

    Mail::assertQueued(
        CourseResetNotificationMail::class,
        fn ($mail): bool => $mail->hasTo($u1->email)
            && $mail->userName === $u1->name
            && $mail->tenantName === 'Acme Auto',
    );
    Mail::assertQueued(
        CourseResetNotificationMail::class,
        fn ($mail): bool => $mail->hasTo($u2->email),
    );
    Mail::assertQueuedCount(2);
});

it('does not queue mail for user IDs that no longer exist in the database', function (): void {
    $u = User::query()->create([
        'name' => 'Real User', 'email' => 'real-'.uniqid().'@test-tenant.localhost', 'password' => bcrypt('x'),
    ]);

    new SendCoursesResetNotifications(
        userIds: collect([$u->id, 999_999]),
        tenantName: 'Acme Auto',
    )->handle();

    Mail::assertQueuedCount(1);
    Mail::assertQueued(CourseResetNotificationMail::class, fn ($mail): bool => $mail->hasTo($u->email));
});

it('chunks users in batches of 100 (smoke test with 150 users)', function (): void {
    $userIds = collect();
    for ($i = 0; $i < 150; $i++) {
        $user = User::query()->create([
            'name' => 'Bulk '.$i,
            'email' => 'bulk-'.$i.'-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);
        $userIds->push($user->id);
    }

    new SendCoursesResetNotifications($userIds, 'Acme Auto')->handle();

    Mail::assertQueuedCount(150);
});
