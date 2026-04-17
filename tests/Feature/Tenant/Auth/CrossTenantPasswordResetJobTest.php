<?php

declare(strict_types=1);

use App\Jobs\CrossTenantPasswordResetJob;
use App\Notifications\TenantResetPasswordNotification;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

it('sends a TenantResetPasswordNotification to a matching tenant user', function (): void {
    Notification::fake();

    // The job runs from central context — end tenancy before dispatching.
    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    Notification::assertSentTo($this->consultant, TenantResetPasswordNotification::class);
});

it('includes a correctly formatted reset URL in the notification', function (): void {
    Notification::fake();

    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    Notification::assertSentTo(
        $this->consultant,
        TenantResetPasswordNotification::class,
        function (TenantResetPasswordNotification $notification): bool {
            // Reflect to access the protected $resetUrl via toMail
            $mail = $notification->toMail($this->consultant);
            $action = collect($mail->actionUrl)->first() ?? $mail->actionUrl;

            expect($action)
                ->toContain('test-tenant.localhost')
                ->toContain('/reset-password/')
                ->toContain(urlencode((string) $this->consultant->email));

            return true;
        }
    );
});

it('stores a hashed token in the tenant password_reset_tokens table', function (): void {
    Notification::fake();

    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    // Re-initialize tenancy to inspect the tenant DB.
    tenancy()->initialize($this->tenant);

    $record = DB::table('password_reset_tokens')
        ->where('email', $this->consultant->email)
        ->first();

    expect($record)->not->toBeNull();
    expect(Hash::isHashed($record->token))->toBeTrue();
});

it('stores a token that is not expired', function (): void {
    Notification::fake();

    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    tenancy()->initialize($this->tenant);

    $record = DB::table('password_reset_tokens')
        ->where('email', $this->consultant->email)
        ->first();

    $createdAt = Date::parse($record->created_at);
    expect($createdAt->diffInSeconds(now()))->toBeLessThan(10);
});

it('does not send a notification when the email does not exist in the tenant DB', function (): void {
    Notification::fake();

    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob('nobody@example.com'));

    Notification::assertNothingSent();
});

it('does not send a notification for suspended dealerships', function (): void {
    Notification::fake();

    $this->tenant->update(['suspended_at' => now()]);
    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    Notification::assertNothingSent();

    // Restore for other tests.
    $this->tenant->update(['suspended_at' => null]);
});

it('ends tenancy after processing each tenant', function (): void {
    Notification::fake();

    tenancy()->end();

    dispatch_sync(new CrossTenantPasswordResetJob($this->consultant->email));

    expect(tenancy()->initialized)->toBeFalse();
});
