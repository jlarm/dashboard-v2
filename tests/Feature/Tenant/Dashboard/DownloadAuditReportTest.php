<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use Spatie\LaravelPdf\Facades\Pdf;

beforeEach(function (): void {
    Pdf::fake();
});

it('redirects guests to login', function (): void {
    tenancy()->end();
    $this->tenant->run(function (): void {
        $this->get(route('dealer.dashboard.audit-report'))
            ->assertRedirect(route('dealer.login'));
    });
});

it('forbids users without an authorized role', function (): void {
    $store = Store::query()->firstOrFail();
    $this->manager->stores()->attach($store->id);
    $this->manager->update(['current_store_id' => $store->id]);

    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard.audit-report'))
        ->assertForbidden();
});

it('returns 404 when the user has an authorized role but no stores in scope', function (): void {
    // StoreScopeService gives every user access when there's only one store in the tenant.
    // Add a second store so non-super-admin/Consultant users are restricted to their own.
    Store::query()->create(['name' => 'Second Store', 'slug' => 'second-store']);

    $owner = App\Models\User::query()->create([
        'name' => 'Empty Owner',
        'email' => 'empty-owner@test-tenant.localhost',
        'password' => bcrypt('password'),
    ]);
    $owner->assignRole('Owner');
    app()->make(Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

    expect($owner->stores()->count())->toBe(0);

    $this->actingAs($owner)
        ->get(route('dealer.dashboard.audit-report'))
        ->assertNotFound();
});

it('streams the executive summary PDF when scope is non-empty and role is authorized', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-report'))
        ->assertOk();

    Pdf::assertRespondedWithPdf(
        fn ($pdf): bool => $pdf->viewName === 'dealer.reports.compliance-summary-pdf',
    );
});
