<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractNotification;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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

it('sends a contract notification to each recipient and appends step 2 per email', function (): void {
    Notification::fake();

    $contract = Contract::factory()->create(['dealer_signature' => null]);

    asSuperAdmin()
        ->post(route('contracts.send', $contract), [
            'emails' => ['one@example.com', 'two@example.com'],
        ])
        ->assertRedirect();

    Notification::assertSentOnDemandTimes(ContractNotification::class, 2);

    expect($contract->status()->where('step', 2)->count())->toBe(2);
});

it('forbids sending after the contract has been signed', function (): void {
    Notification::fake();

    $owner = User::factory()->create();
    $owner->assignRole('Consultant');

    $contract = Contract::factory()->create([
        'user_id' => $owner->id,
        'dealer_signature' => 'signed-path.png',
    ]);

    $this->actingAs($owner)
        ->post(route('contracts.send', $contract), ['emails' => ['foo@example.com']])
        ->assertForbidden();

    Notification::assertNothingSent();
});

it('validates that at least one email is supplied', function (): void {
    $contract = Contract::factory()->create(['dealer_signature' => null]);

    asSuperAdmin()
        ->post(route('contracts.send', $contract), ['emails' => []])
        ->assertSessionHasErrors('emails');
});
