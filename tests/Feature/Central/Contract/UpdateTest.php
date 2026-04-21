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

function validUpdatePayload(Contract $contract, array $overrides = []): array
{
    return array_merge([
        'contract_type' => $contract->contract_type,
        'agreement_date' => $contract->agreement_date?->toDateString(),
        'commence_date' => $contract->commence_date?->toDateString(),
        'dealer_name' => $contract->dealer_name,
        'services' => $contract->services,
        'yearly_inspection_total' => $contract->yearly_inspection_total,
        'initial_fee' => 500,
        'monthly_fee' => 100,
    ], $overrides);
}

it('updates contract fields and appends an "updated" status', function (): void {
    $contract = Contract::factory()->create([
        'armp_signature' => null,
        'dealer_name' => 'Old Motors',
    ]);

    asSuperAdmin()
        ->patch(route('contracts.update', $contract), validUpdatePayload($contract, [
            'dealer_name' => 'New Motors',
        ]))
        ->assertRedirect();

    expect($contract->fresh()->dealer_name)->toBe('New Motors')
        ->and($contract->status()->where('status', 'updated contract')->exists())->toBeTrue();
});

it('stores the ARMP signature and appends step 4 when provided', function (): void {
    $contract = Contract::factory()->create([
        'armp_signature' => null,
        'armp_date_signed' => null,
    ]);

    $dataUri = 'data:image/png;base64,'.base64_encode('fake-signature-bytes');

    asSuperAdmin()
        ->patch(route('contracts.update', $contract), validUpdatePayload($contract, [
            'armp_printed_name' => 'Jane Consultant',
            'armp_signature' => $dataUri,
        ]))
        ->assertRedirect();

    $contract->refresh();

    expect($contract->armp_signature)->not->toBeNull()
        ->and($contract->armp_date_signed)->not->toBeNull()
        ->and($contract->status()->where('step', 4)->exists())->toBeTrue();

    Storage::disk('armpcon')->assertExists($contract->armp_signature);
});

it('forbids updating once the ARMP signature has been saved', function (): void {
    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'armp_signature' => 'existing/path.png',
    ]);

    $this->actingAs($owner)
        ->patch(route('contracts.update', $contract), validUpdatePayload($contract))
        ->assertForbidden();
});

it('forbids non-owner Consultants from updating', function (): void {
    $contract = Contract::factory()->create(['armp_signature' => null]);

    $other = User::factory()->create();
    $other->assignRole('Consultant');

    $this->actingAs($other)
        ->patch(route('contracts.update', $contract), validUpdatePayload($contract))
        ->assertForbidden();
});
