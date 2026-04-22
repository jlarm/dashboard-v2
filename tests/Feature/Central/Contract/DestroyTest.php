<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
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
});

it('deletes an unsigned contract', function (): void {
    $contract = Contract::factory()->create(['dealer_signature' => null]);

    asSuperAdmin()
        ->delete(route('contracts.destroy', $contract))
        ->assertRedirect(route('contracts.index'));

    expect(Contract::query()->find($contract->id))->toBeNull();
});

it('forbids deleting a signed contract', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'dealer_signature' => 'signed-path.png',
    ]);

    $this->actingAs($owner)
        ->delete(route('contracts.destroy', $contract))
        ->assertForbidden();
});

it('forbids non-owners from deleting', function (): void {
    $contract = Contract::factory()->create(['dealer_signature' => null]);

    $otherConsultant = User::factory()->create();
    $otherConsultant->assignRole('Consultant');

    $this->actingAs($otherConsultant)
        ->delete(route('contracts.destroy', $contract))
        ->assertForbidden();
});
