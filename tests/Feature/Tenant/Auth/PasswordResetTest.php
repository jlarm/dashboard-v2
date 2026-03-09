<?php

declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken;
use App\Providers\RouteServiceProvider;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

describe('Tenant Password Reset - Forgot Password Screen', function (): void {
    it('can render the forgot password screen', function (): void {
        $this->get(route('dealer.password.request'))
            ->assertOk();
    });

    it('forgot password form posts to the tenant route', function (): void {
        $response = $this->get(route('dealer.password.request'));

        $response->assertOk();
        $response->assertSee(route('dealer.password.email'), escape: false);
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

    it('logs a warning with email and url when user is not found', function (): void {
        Log::spy();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => 'nonexistent@test.com',
            ]);

        Log::shouldHaveReceived('warning')
            ->once()
            ->withArgs(function (string $message, array $context): bool {
                return $message === 'Failed password reset request'
                    && $context['email'] === 'nonexistent@test.com'
                    && str_contains($context['url'], 'forgot-password');
            });
    });

    it('does not log a warning when reset link is sent successfully', function (): void {
        Notification::fake();
        Log::spy();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Log::shouldNotHaveReceived('warning');
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
    it('reset password form posts to the tenant route', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $response = $this->get(route('dealer.password.reset', ['token' => $notification->token]));

            $response->assertOk();
            $response->assertSee(route('dealer.password.store'), escape: false);

            return true;
        });
    });

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

    it('redirects to the tenant login route after successful reset', function (): void {
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

            $response->assertRedirect(route('dealer.login'));

            return true;
        });
    });

    it('can login with new password after reset', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post(route('dealer.password.store'), [
                    'token' => $notification->token,
                    'email' => $this->consultant->email,
                    'password' => 'new-secure-password-123',
                    'password_confirmation' => 'new-secure-password-123',
                ]);

            return true;
        });

        // Verify the password was updated in the tenant database
        $this->consultant->refresh();
        expect(Hash::check('new-secure-password-123', $this->consultant->password))->toBeTrue();

        // Verify login works with the new password
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => 'new-secure-password-123',
            ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    });

    it('cannot login with old password after reset', function (): void {
        Notification::fake();

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.email'), [
                'email' => $this->consultant->email,
            ]);

        Notification::assertSentTo($this->consultant, ResetPassword::class, function ($notification): bool {
            $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post(route('dealer.password.store'), [
                    'token' => $notification->token,
                    'email' => $this->consultant->email,
                    'password' => 'new-secure-password-123',
                    'password_confirmation' => 'new-secure-password-123',
                ]);

            return true;
        });

        // Verify login fails with the old password
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => 'password',
            ]);

        $this->assertGuest();
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
