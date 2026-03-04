<?php

declare(strict_types=1);

describe('Guest - Unauthenticated Access Redirects to Login', function (): void {
    it('redirects to login from dashboard', function (): void {
        $this->get(route('dealer.dashboard'))
            ->assertRedirect(route('dealer.login'));
    });

    it('redirects to login from courses', function (): void {
        $this->get(route('dealer.courses.index'))
            ->assertRedirect(route('dealer.login'));
    });

    it('redirects to login from SDS sheets', function (): void {
        $this->get(route('dealer.sds.index'))
            ->assertRedirect(route('dealer.login'));
    });

    it('redirects to login from profile', function (): void {
        $this->get(route('dealer.profile.edit'))
            ->assertRedirect(route('dealer.login'));
    });

    it('denies access to employees index', function (): void {
        $response = $this->get(route('dealer.employees.index'));

        // Role middleware may fire before auth, returning 403 instead of redirect
        expect($response->status())->toBeIn([302, 403]);
    });

    it('redirects to login from logs', function (): void {
        $this->get(route('dealer.logs.index'))
            ->assertRedirect(route('dealer.login'));
    });
});

describe('Guest - Public Routes Accessible Without Auth', function (): void {
    it('can access the login page', function (): void {
        $this->get(route('dealer.login'))
            ->assertOk();
    });

    it('can access the forgot password page', function (): void {
        $this->get(route('dealer.password.request'))
            ->assertOk();
    });

    it('can access the tenant welcome page', function (): void {
        $this->get('/')
            ->assertOk();
    });
});
