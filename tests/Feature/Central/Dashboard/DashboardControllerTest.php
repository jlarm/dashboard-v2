<?php

declare(strict_types=1);

use App\Models\Dealership;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('domains')->truncate();
    DB::table('tenant_user')->truncate();
    DB::table('tenants')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

function makeCentralDashboardDealership(string $name, ?User $owner = null): Dealership
{
    $owner ??= User::factory()->create();

    $dealership = new Dealership([
        'name' => $name,
        'user_id' => $owner->id,
    ]);
    $dealership->setInternal('create_database', false);
    $dealership->save();
    $dealership->domains()->create(['domain' => str()->slug($name).'.localhost']);

    return $dealership;
}

function centralDashboardPartialHeaders(string $only): array
{
    $manifest = public_path('build/manifest.json');
    $version = file_exists($manifest) ? hash_file('xxh128', $manifest) : '';

    return [
        'X-Inertia' => 'true',
        'X-Inertia-Version' => $version,
        'X-Inertia-Partial-Component' => 'central/Dashboard',
        'X-Inertia-Partial-Data' => $only,
    ];
}

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()
            ->get(route('dashboard'))
            ->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()
            ->get(route('dashboard'))
            ->assertOk();
    });
});

describe('initial render', function (): void {
    it('renders the dashboard component and defers the dealerships prop', function (): void {
        asSuperAdmin()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/Dashboard')
                ->missing('dealerships')
            );
    });
});

describe('deferred dealerships', function (): void {
    it('returns every dealership for a super-admin', function (): void {
        $alpha = makeCentralDashboardDealership('Alpha Auto');
        $bravo = makeCentralDashboardDealership('Bravo Motors');

        asSuperAdmin()
            ->withHeaders(centralDashboardPartialHeaders('dealerships'))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertJsonCount(2, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.data.0.name', $alpha->name)
            ->assertJsonPath('props.dealerships.data.1.name', $bravo->name);
    });

    it('scopes dealerships to those attached to the Consultant', function (): void {
        $mine = makeCentralDashboardDealership('Mine Motors');
        $others = makeCentralDashboardDealership('Others Motors');

        $consultant = User::factory()->create();
        $consultant->assignRole('Consultant');
        $mine->users()->attach($consultant);

        $otherConsultant = User::factory()->create();
        $otherConsultant->assignRole('Consultant');
        $others->users()->attach($otherConsultant);

        $this->actingAs($consultant)
            ->withHeaders(centralDashboardPartialHeaders('dealerships'))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertJsonCount(1, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.data.0.name', $mine->name);
    });

    it('paginates at 15 per page', function (): void {
        for ($i = 1; $i <= 20; $i++) {
            makeCentralDashboardDealership('Dealer '.mb_str_pad((string) $i, 2, '0', STR_PAD_LEFT));
        }

        asSuperAdmin()
            ->withHeaders(centralDashboardPartialHeaders('dealerships'))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertJsonCount(15, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.meta.per_page', 15)
            ->assertJsonPath('props.dealerships.meta.total', 20);
    });

    it('orders dealerships alphabetically by name', function (): void {
        makeCentralDashboardDealership('Zeta');
        makeCentralDashboardDealership('Alpha');
        makeCentralDashboardDealership('Mu');

        asSuperAdmin()
            ->withHeaders(centralDashboardPartialHeaders('dealerships'))
            ->get(route('dashboard'))
            ->assertOk()
            ->assertJsonPath('props.dealerships.data.0.name', 'Alpha')
            ->assertJsonPath('props.dealerships.data.1.name', 'Mu')
            ->assertJsonPath('props.dealerships.data.2.name', 'Zeta');
    });
});
