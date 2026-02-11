<?php

declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken;
use App\Providers\RouteServiceProvider;

describe('Tenant Auth - Login Screen', function (): void {
    it('can render the login screen', function (): void {
        $this->get(route('dealer.login'))
            ->assertOk();
    });

    it('allows authenticated users to see login page (no guest middleware)', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.login'))
            ->assertOk();
    });
});

describe('Tenant Auth - Authentication', function (): void {
    it('can authenticate using valid credentials', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => 'password',
            ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    });

    it('cannot authenticate with invalid password', function (): void {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => 'wrong-password',
            ]);

        $this->assertGuest();
    });

    it('cannot authenticate with non-existent email', function (): void {
        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => 'nonexistent@test.com',
                'password' => 'password',
            ]);

        $this->assertGuest();
    });

    it('validates that email is required', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => '',
                'password' => 'password',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    });

    it('validates that password is required', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => '',
            ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    });

    it('validates that email must be a valid email address', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => 'not-an-email',
                'password' => 'password',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    });
});

describe('Tenant Auth - Logout', function (): void {
    it('can logout an authenticated user', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.logout'));

        $this->assertGuest();
        $response->assertRedirect('/dashboard');
    });
});

describe('Tenant Auth - Rate Limiting', function (): void {
    it('locks out after too many failed attempts', function (): void {
        for ($i = 0; $i < 5; $i++) {
            $this->withoutMiddleware(VerifyCsrfToken::class)
                ->post(route('dealer.login'), [
                    'email' => $this->consultant->email,
                    'password' => 'wrong-password',
                ]);
        }

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.login'), [
                'email' => $this->consultant->email,
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    });
});
