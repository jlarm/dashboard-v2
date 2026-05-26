<?php

declare(strict_types=1);

use App\Mail\TenDayOpenInviteReminderMail;
use App\Mail\TwentyDayOpenInviteReminderMail;
use App\Models\Dealer\Invite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

beforeEach(function (): void {
    Mail::fake();
    Carbon::setTestNow('2026-06-15 12:00:00');
});

afterEach(function (): void {
    Carbon::setTestNow();
});

/**
 * Create an Invite inside the currently-initialized tenant with its
 * created_at backdated by the given number of days.
 */
function makeAgedInvite(string $email, int $daysOld): Invite
{
    $invite = Invite::query()->create([
        'name' => 'Invitee '.uniqid(),
        'email' => $email,
        'stores' => [],
        'roles' => ['Employee'],
        'invitation_token' => Str::random(32),
        'courses' => [],
    ]);

    Invite::query()
        ->where('id', $invite->id)
        ->update(['created_at' => now()->subDays($daysOld)]);

    return $invite->fresh();
}

it('sends a 10-day reminder for invites created exactly 10 days ago', function (): void {
    $invite = makeAgedInvite('day10@test-tenant.localhost', 10);

    tenancy()->end();

    $this->artisan('run:invites', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    Mail::assertQueued(
        TenDayOpenInviteReminderMail::class,
        fn ($mail): bool => $mail->hasTo($invite->email),
    );
    Mail::assertNotQueued(TwentyDayOpenInviteReminderMail::class);
});

it('sends a 20-day reminder for invites created exactly 20 days ago', function (): void {
    $invite = makeAgedInvite('day20@test-tenant.localhost', 20);

    tenancy()->end();

    $this->artisan('run:invites', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    Mail::assertQueued(
        TwentyDayOpenInviteReminderMail::class,
        fn ($mail): bool => $mail->hasTo($invite->email),
    );
    Mail::assertNotQueued(TenDayOpenInviteReminderMail::class);
});

it('does not send any reminder for invites whose age is not 10 or 20 days', function (): void {
    makeAgedInvite('day1@test-tenant.localhost', 1);
    makeAgedInvite('day5@test-tenant.localhost', 5);
    makeAgedInvite('day15@test-tenant.localhost', 15);
    makeAgedInvite('day25@test-tenant.localhost', 25);

    tenancy()->end();

    $this->artisan('run:invites', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    Mail::assertNothingQueued();
    Mail::assertNothingSent();
});

it('dispatches both reminder types in the same run when both ages are present', function (): void {
    $ten = makeAgedInvite('ten@test-tenant.localhost', 10);
    $twenty = makeAgedInvite('twenty@test-tenant.localhost', 20);

    tenancy()->end();

    $this->artisan('run:invites', ['--tenants' => [$this->tenant->id]])
        ->assertSuccessful();

    Mail::assertQueued(
        TenDayOpenInviteReminderMail::class,
        fn ($mail): bool => $mail->hasTo($ten->email),
    );
    Mail::assertQueued(
        TwentyDayOpenInviteReminderMail::class,
        fn ($mail): bool => $mail->hasTo($twenty->email),
    );
});
