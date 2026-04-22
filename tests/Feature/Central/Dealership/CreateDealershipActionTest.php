<?php

declare(strict_types=1);

use App\Domain\Central\Dealership\Actions\CreateDealership;
use App\Domain\Central\Dealership\Data\DealershipData;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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

    Notification::fake();

    config([
        'tenancy.queue_database_creation' => false,
        'tenancy.queue_database_deletion' => false,
        'tenancy.delete_database_after_tenant_deletion' => true,
    ]);
});

afterEach(function (): void {
    if (tenancy()->initialized) {
        tenancy()->end();
    }

    $prefix = (string) config('tenancy.database.prefix');
    $databases = DB::select("SHOW DATABASES LIKE '{$prefix}%'");
    foreach ($databases as $db) {
        $dbName = $db->{"Database ({$prefix}%)"};
        DB::statement("DROP DATABASE IF EXISTS `{$dbName}`");
    }

    DB::purge('tenant');
});

it('creates selected consultants as users inside the tenant database', function (): void {
    $creator = User::factory()->create(['name' => 'Creator Consultant', 'email' => 'creator@example.test']);
    $creator->assignRole('Consultant');

    $picked = collect([
        ['name' => 'Picked One', 'email' => 'picked-1@example.test'],
        ['name' => 'Picked Two', 'email' => 'picked-2@example.test'],
    ])->map(function (array $attrs): User {
        $user = User::factory()->create($attrs);
        $user->assignRole('Consultant');

        return $user;
    });

    $notPicked = User::factory()->create(['name' => 'Not Picked', 'email' => 'not-picked@example.test']);
    $notPicked->assignRole('Consultant');

    $dealership = resolve(CreateDealership::class)->handle(
        $creator,
        new DealershipData(
            name: 'Consultant Test Motors',
            consultantIds: $picked->pluck('id')->all(),
        ),
    );

    // Central pivot: creator + both picked consultants attached, not-picked excluded.
    $pivotEmails = $dealership->users()->pluck('email')->sort()->values()->all();
    expect($pivotEmails)->toContain('creator@example.test', 'picked-1@example.test', 'picked-2@example.test');
    expect($pivotEmails)->not->toContain('not-picked@example.test');

    // Tenant DB: same users created with the Consultant role.
    [$tenantUsers, $tenantRoles] = $dealership->run(fn (): array => [
        User::query()->orderBy('email')->get(['email', 'name', 'phone'])->toArray(),
        User::query()->get()->mapWithKeys(fn (User $u): array => [$u->email => $u->getRoleNames()->all()])->all(),
    ]);

    $emails = array_column($tenantUsers, 'email');
    expect($emails)->toContain('creator@example.test', 'picked-1@example.test', 'picked-2@example.test');
    expect($emails)->not->toContain('not-picked@example.test');

    expect($tenantRoles['picked-1@example.test'])->toContain('Consultant');
    expect($tenantRoles['picked-2@example.test'])->toContain('Consultant');
    expect($tenantRoles['creator@example.test'])->toContain('Consultant');
});

it('creates only the creator in the tenant when no consultants are selected', function (): void {
    $creator = User::factory()->create(['email' => 'solo@example.test']);
    $creator->assignRole('Consultant');

    $dealership = resolve(CreateDealership::class)->handle(
        $creator,
        new DealershipData(name: 'Solo Motors'),
    );

    $tenantEmails = $dealership->run(fn (): array => User::query()->pluck('email')->all());

    expect($tenantEmails)->toEqual(['solo@example.test']);
});

it('always includes every super-admin in the tenant regardless of selection', function (): void {
    $admin = User::factory()->create(['email' => 'admin@example.test']);
    $admin->assignRole('super-admin');

    $creator = User::factory()->create(['email' => 'creator@example.test']);
    $creator->assignRole('Consultant');

    $picked = User::factory()->create(['email' => 'picked@example.test']);
    $picked->assignRole('Consultant');

    $dealership = resolve(CreateDealership::class)->handle(
        $creator,
        new DealershipData(name: 'Admin Motors', consultantIds: [$picked->id]),
    );

    [$tenantEmails, $adminRoles] = $dealership->run(fn (): array => [
        User::query()->orderBy('email')->pluck('email')->all(),
        User::query()->where('email', 'admin@example.test')->first()?->getRoleNames()->all() ?? [],
    ]);

    expect($tenantEmails)->toContain('admin@example.test', 'creator@example.test', 'picked@example.test');
    expect($adminRoles)->toContain('super-admin');
});

it('ignores non-Consultant ids passed in consultantIds', function (): void {
    $creator = User::factory()->create(['email' => 'creator@example.test']);
    $creator->assignRole('Consultant');

    $stranger = User::factory()->create(['email' => 'stranger@example.test']);
    // No role — should be filtered out by ->role('Consultant') scope.

    $dealership = resolve(CreateDealership::class)->handle(
        $creator,
        new DealershipData(name: 'Stranger Motors', consultantIds: [$stranger->id]),
    );

    $tenantEmails = $dealership->run(fn (): array => User::query()->pluck('email')->all());

    expect($tenantEmails)->toContain('creator@example.test');
    expect($tenantEmails)->not->toContain('stranger@example.test');
});
