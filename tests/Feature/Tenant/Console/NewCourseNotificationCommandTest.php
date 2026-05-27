<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\NewCourseNotification;
use Illuminate\Support\Facades\Notification;

it('sends a NewCourseNotification to every user except the three hard-coded exclusions', function (): void {
    Notification::fake();

    $kept = User::query()->create([
        'name' => 'Anyone Else',
        'email' => 'anyone-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);
    $skippedJoe = User::query()->create([
        'name' => 'Joe Lohr',
        'email' => 'joe-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);
    $skippedTerry = User::query()->create([
        'name' => 'Terry Dortch',
        'email' => 'terry-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);

    tenancy()->end();
    $this->artisan('courses:new-notification', ['--tenants' => [$this->tenant->id]])
        ->expectsOutputToContain('Command completed successfully')
        ->assertExitCode(0);

    Notification::assertSentTo($kept, NewCourseNotification::class);
    Notification::assertNotSentTo($skippedJoe, NewCourseNotification::class);
    Notification::assertNotSentTo($skippedTerry, NewCourseNotification::class);
});
