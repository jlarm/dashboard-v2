<?php

declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

describe('Tenant Password Reset - Forgot Password Screen', function (): void {
    it('can render the forgot password screen', function (): void {
        $this->get(route('dealer.password.request'))
            ->assertOk();
    });
});

describe('Tenant Password Reset - Request Reset Link', function (): void {
    it('can request a password reset link', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class);
    });

    it('does not send reset link for non-existent email', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => 'nonexistent@test.com',
            ]);

        Notification::assertNothingSent();
    });

    it('validates that email is required', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => '',
            ]);

        $response->assertSessionHasErrors('email');
    });

    it('validates that email must be valid', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => 'not-an-email',
            ]);

        $response->assertSessionHasErrors('email');
    });
});

describe('Tenant Password Reset - Reset Password Screen', function (): void {
    it('can render the reset password screen with valid token', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $response = $this->get(route('dealer.password.reset', ['token' => $notification->token]));

            $response->assertOk();

            return true;
        });
    });
});

describe('Tenant Password Reset - Reset Password', function (): void {
    it('can reset password with valid token', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $response = $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post(route('dealer.password.store'), [
                    'token' => $notification->token,
                    'email' => $this->consultant->email,
                    'password' => 'new-secure-password-123',
                    'password_confirmation' => 'new-secure-password-123',
                ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    });

    it('cannot reset password with invalid token', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.store'), [
                'token' => 'invalid-token',
                'email' => $this->consultant->email,
                'password' => 'new-secure-password-123',
                'password_confirmation' => 'new-secure-password-123',
            ]);

        $response->assertSessionHasErrors('email');
    });

    it('cannot reset password with mismatched confirmation', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $response = $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post(route('dealer.password.store'), [
                    'token' => $notification->token,
                    'email' => $this->consultant->email,
                    'password' => 'new-secure-password-123',
                    'password_confirmation' => 'different-password',
                ]);

            $response->assertSessionHasErrors('password');

            return true;
        });
    });
});
