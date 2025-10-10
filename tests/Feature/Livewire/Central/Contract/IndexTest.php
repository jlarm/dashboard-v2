<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Contracts\Index;
use App\Models\Contract;
use App\Models\User;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(DepartmentSeeder::class);
    $this->seed(RoleAndPermissionSeeder::class);
});

it('displays contracts index page as consultant', function (): void {
    $consultant = User::factory()->create();
    $consultant->assignRole('Consultant');
    $this->actingAs($consultant);

    $this->get(route('contracts.index'))
        ->assertOk()
        ->assertDontSee('Id')
        ->assertDontSee('Consultant')
        ->assertSeeLivewire(Index::class);
});

it('displays contracts index page as super-admin', function (): void {
    $superAdmin = User::factory()->create();
    $superAdmin->assignRole('super-admin');
    $this->actingAs($superAdmin);

    $this->get(route('contracts.index'))
        ->assertOk()
        ->assertSee('Id')
        ->assertSee('Consultant')
        ->assertSeeLivewire(Index::class);
});

test('super admin sees all contracts', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('super-admin');

    $consultant = User::factory()->create();
    $consultant->assignRole('Consultant');

    $adminContract = Contract::factory()->create([
        'user_id' => $admin->id,
        'dealer_name' => 'Admin Dealership',
    ]);
    $consultantContract = Contract::factory()->create([
        'user_id' => $consultant->id,
        'dealer_name' => 'Consultant Dealership',
    ]);

    Livewire::actingAs($admin)
        ->test(Index::class)
        ->assertSee('Admin Dealership', 'Super admin should see their own contracts')
        ->assertSee('Consultant Dealership', 'Super admin should see all contracts');

    $this->assertDatabaseHas('contracts', [
        'id' => $adminContract->id,
        'dealer_name' => 'Admin Dealership',
    ], null, 'Expected to find admin contract in database');
});

test('consultant sees only their contracts', function (): void {
    $admin = User::factory()->create();
    $admin->assignRole('super-admin');

    $consultant = User::factory()->create();
    $consultant->assignRole('Consultant');

    Contract::factory()->create([
        'user_id' => $admin->id,
        'dealer_name' => 'Admin Dealership',
    ]);
    $consultantContract = Contract::factory()->create([
        'user_id' => $consultant->id,
        'dealer_name' => 'Consultant Dealership',
    ]);

    Livewire::actingAs($consultant)
        ->test(Index::class)
        ->assertDontSee('Admin Dealership', 'Consultant should not see other contracts')
        ->assertSee('Consultant Dealership', 'Consultant should see their contracts');

    $this->assertDatabaseHas('contracts', [
        'id' => $consultantContract->id,
        'dealer_name' => 'Consultant Dealership',
    ], null, 'Expected to find consultant contract in database');
});
