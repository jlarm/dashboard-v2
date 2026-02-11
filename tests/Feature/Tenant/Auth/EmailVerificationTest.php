<?php

declare(strict_types=1);

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

describe('Tenant Email Verification - Prompt Screen', function (): void {
    it('renders the verification notice for unverified users', function (): void {
        $unverified = User::query()->create([
            'name' => 'Unverified User',
            'email' => 'unverified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);

        $this->actingAs($unverified)
            ->get(route('dealer.verification.notice'))
            ->assertOk();
    });

    it('redirects verified users away from the verification notice', function (): void {
        $verified = User::query()->create([
            'name' => 'Verified User',
            'email' => 'verified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $this->actingAs($verified)
            ->get(route('dealer.verification.notice'))
            ->assertRedirect();
    });
});

describe('Tenant Email Verification - Verify Email', function (): void {
    it('can verify email with valid signed URL', function (): void {
        $unverified = User::query()->create([
            'name' => 'Unverified User',
            'email' => 'unverified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'dealer.verification.verify',
            now()->addMinutes(60),
            ['id' => $unverified->id, 'hash' => sha1($unverified->email)]
        );

        $response = $this->actingAs($unverified)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        expect($unverified->fresh()->hasVerifiedEmail())->toBeTrue();
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    });

    it('does not verify email with invalid hash', function (): void {
        $unverified = User::query()->create([
            'name' => 'Unverified User',
            'email' => 'unverified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'dealer.verification.verify',
            now()->addMinutes(60),
            ['id' => $unverified->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($unverified)->get($verificationUrl);

        expect($unverified->fresh()->hasVerifiedEmail())->toBeFalse();
    });

    it('redirects already verified users', function (): void {
        $verificationUrl = URL::temporarySignedRoute(
            'dealer.verification.verify',
            now()->addMinutes(60),
            ['id' => $this->consultant->id, 'hash' => sha1($this->consultant->email)]
        );

        $response = $this->actingAs($this->consultant)->get($verificationUrl);

        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
    });
});

describe('Tenant Email Verification - Resend Notification', function (): void {
    it('can resend verification notification', function (): void {
        $unverified = User::query()->create([
            'name' => 'Unverified User',
            'email' => 'unverified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($unverified)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.verification.send'));

        $response->assertRedirect();
        $response->assertSessionHas('status', 'verification-link-sent');
    });

    it('does not resend to already verified users', function (): void {
        $verified = User::query()->create([
            'name' => 'Verified User',
            'email' => 'verified@test.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($verified)
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('dealer.verification.send'));

        $response->assertRedirect();
    });
});
