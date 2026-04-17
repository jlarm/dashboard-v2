<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;

it('returns 404 when accessing a soft-deleted tenant domain', function (): void {
    tenancy()->end();

    $this->tenant->delete();

    $this->get('/')
        ->assertNotFound();
});

it('returns 503 with tenant-suspended view when tenant is suspended', function (): void {
    tenancy()->end();

    $this->tenant->update(['suspended_at' => Date::now()]);

    $this->get('/')
        ->assertStatus(503)
        ->assertViewIs('errors.tenant-suspended');
});

it('allows access to an active tenant', function (): void {
    tenancy()->end();

    $this->get(route('dealer.login'))
        ->assertOk();
});
