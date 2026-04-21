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

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('contracts.index'))->assertRedirect(route('login'));
    });

    it('forbids users without the Consultant or super-admin role', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('contracts.index'))->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()->get(route('contracts.index'))->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()->get(route('contracts.index'))->assertOk();
    });
});

describe('listing', function (): void {
    it('returns all contracts to super-admins', function (): void {
        Contract::factory()->count(3)->create();

        asSuperAdmin()
            ->get(route('contracts.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/contract/Index')
                ->has('contracts.data', 3));
    });

    it('scopes contracts to the consultant owner', function (): void {
        $consultant = User::factory()->create();
        $consultant->assignRole('Consultant');

        Contract::factory()->count(2)->create(['user_id' => $consultant->id]);
        Contract::factory()->count(2)->create();

        $this->actingAs($consultant)
            ->get(route('contracts.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->has('contracts.data', 2));
    });
});
