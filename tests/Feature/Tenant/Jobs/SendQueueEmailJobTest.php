<?php

declare(strict_types=1);

use App\Jobs\SendQueueEmailJob;
use App\Mail\InviteMail;
use App\Models\Dealer\Invite;
use Illuminate\Support\Facades\Mail;

it('mails the InviteMail to the invite address when handled', function (): void {
    Mail::fake();

    $invite = Invite::query()->create([
        'name' => 'New Hire',
        'roles' => [],
        'email' => 'new-hire-'.uniqid().'@test-tenant.localhost',
        'invitation_token' => bin2hex(random_bytes(16)),
    ]);

    new SendQueueEmailJob($invite)->handle();

    Mail::assertSent(InviteMail::class, fn (InviteMail $mail): bool => $mail->hasTo($invite->email));
});

it('reports the exception when the queued send fails', function (): void {
    $invite = Invite::query()->create([
        'name' => 'New Hire',
        'roles' => [],
        'email' => 'fail-'.uniqid().'@test-tenant.localhost',
        'invitation_token' => bin2hex(random_bytes(16)),
    ]);

    expect(fn () => new SendQueueEmailJob($invite)->failed(new RuntimeException('smtp down')))
        ->not->toThrow(Throwable::class);
});

it('is a no-op when failed() is called without an exception', function (): void {
    $invite = Invite::query()->create([
        'name' => 'New Hire',
        'roles' => [],
        'email' => 'noop-'.uniqid().'@test-tenant.localhost',
        'invitation_token' => bin2hex(random_bytes(16)),
    ]);

    expect(fn () => new SendQueueEmailJob($invite)->failed(null))->not->toThrow(Throwable::class);
});
