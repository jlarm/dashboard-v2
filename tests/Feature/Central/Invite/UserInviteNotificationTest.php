<?php

declare(strict_types=1);

use App\Models\Central\UserInvite;
use App\Notifications\Central\UserInviteNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\DB;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('user_invites')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
});

it('routes only through the mail channel', function (): void {
    $invite = UserInvite::factory()->create();

    $channels = (new UserInviteNotification($invite))->via(new AnonymousNotifiable);

    expect($channels)->toBe(['mail']);
});

it('builds a MailMessage with the configured app name and invitee greeting', function (): void {
    $invite = UserInvite::factory()->create();

    $message = (new UserInviteNotification($invite))->toMail(new AnonymousNotifiable);

    $appName = (string) config('app.name');

    expect($message)->toBeInstanceOf(MailMessage::class)
        ->and($message->subject)->toBe('Invitation to join '.$appName)
        ->and($message->greeting)->toBe('Hello '.$invite->name.',')
        ->and($message->actionText)->toBe('Complete Registration');
});

it('points the action button at a temporary signed registration URL for the invite', function (): void {
    $invite = UserInvite::factory()->create();

    $message = (new UserInviteNotification($invite))->toMail(new AnonymousNotifiable);

    expect($message->actionUrl)
        ->toBeString()
        ->toContain('/employees/register/'.$invite->id)
        ->toContain('signature=')
        ->toContain('expires=');
});

it('mentions the invite expiry timestamp in the body', function (): void {
    $invite = UserInvite::factory()->create(['expires_at' => now()->addDays(7)]);

    $message = (new UserInviteNotification($invite))->toMail(new AnonymousNotifiable);

    $body = implode("\n", [...$message->introLines, ...$message->outroLines]);

    expect($body)->toContain($invite->expires_at->toDayDateTimeString());
});

it('returns only the invite id in the database representation', function (): void {
    $invite = UserInvite::factory()->create();

    $data = (new UserInviteNotification($invite))->toArray(new AnonymousNotifiable);

    expect($data)->toBe(['central_user_invite_id' => $invite->id]);
});
