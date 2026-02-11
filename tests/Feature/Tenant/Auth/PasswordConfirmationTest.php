<?php

declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken;

describe('Tenant Password Confirmation - Render', function (): void {
    it('can render the password confirmation screen', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.password.confirm'))
            ->assertOk();
    });

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.password.confirm'))
            ->assertRedirect(route('dealer.login'));
    });
});

describe('Tenant Password Confirmation - Confirm', function (): void {
    it('can confirm password with correct password', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.confirm'), [
                'password' => 'password',
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    });

    it('cannot confirm password with incorrect password', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.password.confirm'), [
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors();
    });
});
