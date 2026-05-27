<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Carbon;

beforeEach(function (): void {
    $this->user = User::query()->create([
        'name' => 'Profile Tester',
        'email' => 'profile-tester-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('secret'),
        'email_verified_at' => Carbon::parse('2026-01-01 12:00:00'),
    ]);
});

describe('GET /profile', function (): void {
    it('redirects unauthenticated visitors to the login screen', function (): void {
        $this->get(route('dealer.profile.edit'))->assertRedirect(route('dealer.login'));
    });

    it('renders the Profile Inertia page for the authenticated user', function (): void {
        $this->actingAs($this->user)
            ->get(route('dealer.profile.edit'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/Profile')
                ->where('status', null)
                ->has('mustVerifyEmail')
            );
    });

    it('exposes a flashed status string when one is set in the session', function (): void {
        $this->actingAs($this->user)
            ->withSession(['status' => 'verification-link-sent'])
            ->get(route('dealer.profile.edit'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('status', 'verification-link-sent'));
    });
});

describe('PATCH /profile', function (): void {
    it('updates name and email when both pass validation', function (): void {
        $this->actingAs($this->user)
            ->patch(route('dealer.profile.update'), [
                'name' => 'Renamed Person',
                'email' => 'renamed-'.uniqid().'@test-tenant.localhost',
            ])
            ->assertRedirect(route('dealer.profile.edit'));

        $fresh = $this->user->fresh();
        expect($fresh->name)->toBe('Renamed Person');
        expect($fresh->email)->toStartWith('renamed-');
    });

    it('clears email_verified_at when the user changes their email', function (): void {
        $newEmail = 'newemail-'.uniqid().'@test-tenant.localhost';

        $this->actingAs($this->user)
            ->patch(route('dealer.profile.update'), [
                'name' => $this->user->name,
                'email' => $newEmail,
            ])
            ->assertRedirect(route('dealer.profile.edit'));

        expect($this->user->fresh()->email_verified_at)->toBeNull();
    });

    it('keeps email_verified_at when name changes but email does not', function (): void {
        $this->actingAs($this->user)
            ->patch(route('dealer.profile.update'), [
                'name' => 'Just A New Name',
                'email' => $this->user->email,
            ])
            ->assertRedirect(route('dealer.profile.edit'));

        expect($this->user->fresh()->email_verified_at?->toDateTimeString())->toBe('2026-01-01 12:00:00');
    });

    it('rejects updates that try to take an email already used by another user', function (): void {
        $other = User::query()->create([
            'name' => 'Other Person',
            'email' => 'other-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);

        $this->actingAs($this->user)
            ->from(route('dealer.profile.edit'))
            ->patch(route('dealer.profile.update'), [
                'name' => $this->user->name,
                'email' => $other->email,
            ])
            ->assertSessionHasErrors('email');

        expect($this->user->fresh()->email)->not->toBe($other->email);
    });

    it('rejects updates that omit the required name', function (): void {
        $this->actingAs($this->user)
            ->from(route('dealer.profile.edit'))
            ->patch(route('dealer.profile.update'), [
                'name' => '',
                'email' => $this->user->email,
            ])
            ->assertSessionHasErrors('name');
    });

    it('rejects updates whose email is not a valid email address', function (): void {
        $this->actingAs($this->user)
            ->from(route('dealer.profile.edit'))
            ->patch(route('dealer.profile.update'), [
                'name' => $this->user->name,
                'email' => 'not-an-email',
            ])
            ->assertSessionHasErrors('email');
    });
});
