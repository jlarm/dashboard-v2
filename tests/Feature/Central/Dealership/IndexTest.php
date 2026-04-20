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

function makeDealership(string $name, ?User $owner = null): Dealership
{
    $owner ??= User::factory()->create();

    // Skip real tenant database provisioning for index-only assertions.
    $dealership = new Dealership([
        'name' => $name,
        'user_id' => $owner->id,
    ]);
    $dealership->setInternal('create_database', false);
    $dealership->save();
    $dealership->domains()->create(['domain' => str()->slug($name).'.localhost']);

    return $dealership;
}

function partialInertiaHeaders(string $only): array
{
    $manifest = public_path('build/manifest.json');
    $version = file_exists($manifest) ? hash_file('xxh128', $manifest) : '';

    return [
        'X-Inertia' => 'true',
        'X-Inertia-Version' => $version,
        'X-Inertia-Partial-Component' => 'central/dealership/Index',
        'X-Inertia-Partial-Data' => $only,
    ];
}

describe('authorization', function (): void {
    it('redirects guests to login', function (): void {
        $this->get(route('dealerships.index'))->assertRedirect(route('login'));
    });

    it('forbids users with neither super-admin nor Consultant', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dealerships.index'))
            ->assertForbidden();
    });

    it('allows super-admins', function (): void {
        asSuperAdmin()
            ->get(route('dealerships.index'))
            ->assertOk();
    });

    it('allows Consultants', function (): void {
        asConsultant()
            ->get(route('dealerships.index'))
            ->assertOk();
    });
});

describe('initial render', function (): void {
    it('defers dealerships and consultants on the initial visit', function (): void {
        asSuperAdmin()
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('central/dealership/Index')
                ->has('filters')
                ->missing('dealerships')
                ->missing('consultants')
            );
    });

    it('passes the search query back as a filter', function (): void {
        asSuperAdmin()
            ->get(route('dealerships.index', ['search' => 'Acme']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('filters.search', 'Acme'));
    });
});

describe('deferred dealerships', function (): void {
    it('returns every dealership to super-admins', function (): void {
        makeDealership('Alpha Auto');
        makeDealership('Bravo Motors');

        asSuperAdmin()
            ->withHeaders(partialInertiaHeaders('dealerships'))
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertJsonCount(2, 'props.dealerships.data');
    });

    it('scopes dealerships to those attached to the Consultant', function (): void {
        $mine = makeDealership('Mine Motors');
        $others = makeDealership('Others Motors');

        $consultant = User::factory()->create();
        $consultant->assignRole('Consultant');
        $mine->users()->attach($consultant);

        $otherConsultant = User::factory()->create();
        $otherConsultant->assignRole('Consultant');
        $others->users()->attach($otherConsultant);

        $this->actingAs($consultant)
            ->withHeaders(partialInertiaHeaders('dealerships'))
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertJsonCount(1, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.data.0.name', 'Mine Motors');
    });

    it('applies the search filter (case-insensitive like)', function (): void {
        makeDealership('Alpha Auto');
        makeDealership('Bravo Motors');

        asSuperAdmin()
            ->withHeaders(partialInertiaHeaders('dealerships'))
            ->get(route('dealerships.index', ['search' => 'bravo']))
            ->assertOk()
            ->assertJsonCount(1, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.data.0.name', 'Bravo Motors');
    });

    it('paginates at 15 per page', function (): void {
        for ($i = 1; $i <= 20; $i++) {
            makeDealership('Dealer '.mb_str_pad((string) $i, 2, '0', STR_PAD_LEFT));
        }

        asSuperAdmin()
            ->withHeaders(partialInertiaHeaders('dealerships'))
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertJsonCount(15, 'props.dealerships.data')
            ->assertJsonPath('props.dealerships.meta.per_page', 15)
            ->assertJsonPath('props.dealerships.meta.total', 20);
    });
});

describe('deferred consultants', function (): void {
    it('excludes the current user from the consultants list and orders by name', function (): void {
        $zach = User::factory()->create(['name' => 'Zach Consultant']);
        $zach->assignRole('Consultant');

        $amy = User::factory()->create(['name' => 'Amy Consultant']);
        $amy->assignRole('Consultant');

        $currentConsultant = User::factory()->create(['name' => 'Current']);
        $currentConsultant->assignRole('Consultant');

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($currentConsultant)
            ->withHeaders(partialInertiaHeaders('consultants'))
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertJsonCount(2, 'props.consultants')
            ->assertJsonPath('props.consultants.0.name', 'Amy Consultant')
            ->assertJsonPath('props.consultants.1.name', 'Zach Consultant');
    });

    it('excludes users with other roles from the consultants list', function (): void {
        $super = User::factory()->create(['name' => 'Super Admin']);
        $super->assignRole('super-admin');

        $consultant = User::factory()->create(['name' => 'Real Consultant']);
        $consultant->assignRole('Consultant');

        asSuperAdmin()
            ->withHeaders(partialInertiaHeaders('consultants'))
            ->get(route('dealerships.index'))
            ->assertOk()
            ->assertJsonCount(1, 'props.consultants')
            ->assertJsonPath('props.consultants.0.name', 'Real Consultant');
    });
});
