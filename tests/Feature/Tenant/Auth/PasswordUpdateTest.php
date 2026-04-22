<?php

declare(strict_types=1);

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Hash;

describe('Tenant Password Update', function (): void {
    it('can update password with valid current password', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('dealer.password.update'), [
                'current_password' => 'password',
                'password' => 'new-secure-password-123',
                'password_confirmation' => 'new-secure-password-123',
            ]);

        $response->assertSessionHasNoErrors();
        expect(Hash::check('new-secure-password-123', $this->consultant->refresh()->password))->toBeTrue();
    });

    it('cannot update password with incorrect current password', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('dealer.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'new-secure-password-123',
                'password_confirmation' => 'new-secure-password-123',
            ]);

        $response->assertSessionHasErrors('current_password');
    });

    it('cannot update password with mismatched confirmation', function (): void {
        $response = $this->actingAs($this->consultant)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('dealer.password.update'), [
                'current_password' => 'password',
                'password' => 'new-secure-password-123',
                'password_confirmation' => 'different-password',
            ]);

        $response->assertSessionHasErrors('password');
    });

    it('requires authentication to update password', function (): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('dealer.password.update'), [
                'current_password' => 'password',
                'password' => 'new-secure-password-123',
                'password_confirmation' => 'new-secure-password-123',
            ]);

        $response->assertRedirect(route('dealer.login'));
    });
});
