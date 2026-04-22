<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contract_statuses')->truncate();
    DB::table('contracts')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('armpcon');
});

it('renders the edit component for super-admin (Gate::before grants every ability)', function (): void {
    $contract = Contract::factory()->create([
        'armp_signature' => null,
        'dealer_signature' => null,
        'pdf_path' => null,
    ]);

    asSuperAdmin()
        ->get(route('contracts.edit', $contract))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('central/contract/Edit')
            ->where('contract.uuid', $contract->uuid)
            ->where('can.update', true)
            ->where('can.delete', true)
        );
});

it('reflects state-dependent abilities for the Consultant who owns the contract', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'armp_signature' => null,
        'dealer_signature' => null,
        'pdf_path' => null,
    ]);

    $this->actingAs($owner)
        ->get(route('contracts.edit', $contract))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('can.update', true)
            ->where('can.delete', true)
            ->where('can.sendForReview', true)
            ->where('can.generatePdf', false)
            ->where('can.sendPdf', false)
            ->where('can.downloadPdf', false)
        );
});

it('locks the Consultant owner out of mutating abilities after ARMP signs', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'armp_signature' => 'armp/signed.png',
        'dealer_signature' => null,
        'pdf_path' => 'pdfs/contract.pdf',
    ]);

    $this->actingAs($owner)
        ->get(route('contracts.edit', $contract))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->where('can.update', false)
            ->where('can.delete', true)
            ->where('can.generatePdf', true)
            ->where('can.sendPdf', true)
            ->where('can.downloadPdf', true)
        );
});

it('forbids a Consultant who does not own the contract', function (): void {
    $contract = Contract::factory()->create();

    asConsultant()
        ->get(route('contracts.edit', $contract))
        ->assertForbidden();
});

it('returns 404 for an unknown uuid', function (): void {
    asSuperAdmin()
        ->get(route('contracts.edit', '00000000-0000-0000-0000-000000000000'))
        ->assertNotFound();
});
