<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;

describe('Tenant Email Verification Disabled', function (): void {
    it('does not register tenant verification route names', function (): void {
        expect(Route::has('dealer.verification.notice'))->toBeFalse();
        expect(Route::has('dealer.verification.verify'))->toBeFalse();
        expect(Route::has('dealer.verification.send'))->toBeFalse();
    });

    it('returns not found for old verify-email path', function (): void {
        $user = User::query()->create([
            'name' => 'Tenant User',
            'email' => 'tenant-user@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
            ->get('/verify-email')
            ->assertNotFound();
    });

    it('returns not found for old resend verification path', function (): void {
        $user = User::query()->create([
            'name' => 'Tenant User',
            'email' => 'tenant-user-2@test.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user)
            ->post('/email/verification-notification')
            ->assertNotFound();
    });
});
