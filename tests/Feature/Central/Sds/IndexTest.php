<?php

declare(strict_types=1);

use App\Models\Sds;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('model_has_roles')->truncate();
    DB::table('users')->truncate();
    DB::table('sds')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('sds.index'))->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('sds.index'))
            ->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()
            ->get(route('sds.index'))
            ->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()
            ->get(route('sds.index'))
            ->assertOk();
    });
});

describe('initial render', function (): void {
    it('renders the index component with paginated sheets', function (): void {
        Sds::factory()->create(['name' => 'Acetone']);
        Sds::factory()->create(['name' => 'Benzene']);

        asSuperAdmin()
            ->get(route('sds.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/sds/Index')
                ->has('sheets.data', 2)
                ->where('sheets.data.0.name', 'Acetone')
                ->has('filters')
                ->where('can.create', true)
                ->where('can.update', true)
                ->where('can.delete', true)
            );
    });

    it('filters sheets by search query', function (): void {
        Sds::factory()->create(['name' => 'Acetone', 'manufacturer' => 'ChemCo']);
        Sds::factory()->create(['name' => 'Benzene', 'manufacturer' => 'OtherCo']);

        asSuperAdmin()
            ->get(route('sds.index', ['search' => 'ChemCo']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/sds/Index')
                ->has('sheets.data', 1)
                ->where('sheets.data.0.name', 'Acetone')
                ->where('filters.search', 'ChemCo')
            );
    });

    it('hides write permissions from Consultants', function (): void {
        asConsultant()
            ->get(route('sds.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('can.create', false)
                ->where('can.update', false)
                ->where('can.delete', false)
            );
    });
});
