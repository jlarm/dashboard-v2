<?php

declare(strict_types=1);

use App\Enums\Service;
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

function validContractPayload(array $overrides = []): array
{
    return array_merge([
        'contract_type' => 'yearly',
        'agreement_date' => now()->toDateString(),
        'commence_date' => now()->addWeek()->toDateString(),
        'dealer_name' => 'Acme Motors',
        'services' => [Service::GLBA->value],
        'yearly_inspection_total' => 4,
        'initial_fee' => 500,
        'monthly_fee' => 100,
    ], $overrides);
}

it('creates a contract and redirects to edit', function (): void {
    asSuperAdmin()
        ->post(route('contracts.store'), validContractPayload())
        ->assertRedirect();

    $contract = Contract::firstOrFail();

    expect($contract->dealer_name)->toBe('Acme Motors')
        ->and($contract->services)->toBe([Service::GLBA->value]);
});

it('stores services as a real array (no double-encoded JSON)', function (): void {
    asSuperAdmin()
        ->post(route('contracts.store'), validContractPayload([
            'services' => [Service::GLBA->value, Service::OSHA->value],
        ]));

    $raw = DB::table('contracts')->value('services');

    expect(json_decode((string) $raw, true))->toBe([Service::GLBA->value, Service::OSHA->value]);
});

it('appends a "created contract" status on creation', function (): void {
    asSuperAdmin()->post(route('contracts.store'), validContractPayload());

    $contract = Contract::with('status')->firstOrFail();

    expect($contract->status)->toHaveCount(1)
        ->and($contract->status->first()->step)->toBe(1);
});

it('rejects unknown service values', function (): void {
    asSuperAdmin()
        ->post(route('contracts.store'), validContractPayload(['services' => ['bogus']]))
        ->assertSessionHasErrors('services.0');
});

it('forbids users without the create ability', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('contracts.store'), validContractPayload())
        ->assertForbidden();
});
