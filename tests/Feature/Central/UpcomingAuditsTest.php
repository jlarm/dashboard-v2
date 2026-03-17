<?php

declare(strict_types=1);

use App\Http\Livewire\Central\UpcomingAudits;
use App\Models\Dealer\Audit\BodyShopAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\FinanceAudit;
use App\Models\Dealer\Audit\OshaAudit;
use App\Models\Dealer\Store;
use App\Models\Dealership;
use App\Models\User;
use App\Services\DealershipCreator;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->seed(RoleAndPermissionSeeder::class);
    app()[PermissionRegistrar::class]->forgetCachedPermissions();
    Cache::flush();
});

function makeAdmin(): User
{
    $user = User::query()->firstOrCreate(
        ['email' => 'test.admin.'.Str::random(6).'@example.com'],
        ['name' => 'Test Admin', 'phone' => '1111111111', 'email_verified_at' => now(), 'password' => bcrypt('password')]
    );
    $user->assignRole('super-admin');

    return $user;
}

function makeTestDealership(User $user): Dealership
{
    return app(DealershipCreator::class)->create($user, 'Test '.Str::upper(Str::random(6)));
}

function cleanupDealership(Dealership $dealership): void
{
    $dealership->users()->detach();
    $dealership->forceDelete();
}

it('shows stores with no audits this quarter', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(fn (): string => Store::create(['name' => 'Main Store'])->name);

        Cache::flush();

        // Single-store dealership: only the store name appears, not the dealership name
        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertSee($storeName)
            ->assertDontSee($dealership->name);
    } finally {
        cleanupDealership($dealership);
    }
});

it('excludes stores with all required audits completed this quarter', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(function (): string {
            $store = Store::create(['name' => 'Complete Store']);
            OshaAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            FinanceAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            DealJacketGroup::create(['uuid' => Str::uuid(), 'store_id' => $store->id, 'completed' => true]);

            return $store->name;
        });

        Cache::flush();

        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertDontSee($storeName);
    } finally {
        cleanupDealership($dealership);
    }
});

it('shows stores missing only some audit types', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(function (): string {
            $store = Store::create(['name' => 'Partial Store']);
            OshaAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            // finance and deal jacket absent

            return $store->name;
        });

        Cache::flush();

        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertSee($storeName);
    } finally {
        cleanupDealership($dealership);
    }
});

it('marks body shop as N/A for stores with no body shop audit history', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $dealership->run(function (): void {
            $store = Store::create(['name' => 'No Body Shop Store']);
            OshaAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            FinanceAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            DealJacketGroup::create(['uuid' => Str::uuid(), 'store_id' => $store->id, 'completed' => true]);
            // no body shop audit — ever
        });

        Cache::flush();

        // Store has no body shop history, so it should be fully complete without one
        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertDontSee('No Body Shop Store');
    } finally {
        cleanupDealership($dealership);
    }
});

it('requires body shop audit for stores with prior body shop history', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(function (): string {
            $store = Store::create(['name' => 'Has Body Shop Store']);
            // prior quarter body shop audit establishes history
            BodyShopAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()->subQuarter()]);
            OshaAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            FinanceAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => now()]);
            DealJacketGroup::create(['uuid' => Str::uuid(), 'store_id' => $store->id, 'completed' => true]);
            // no body shop audit this quarter

            return $store->name;
        });

        Cache::flush();

        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertSee($storeName);
    } finally {
        cleanupDealership($dealership);
    }
});

it('excludes audits from previous quarters', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(function (): string {
            $store = Store::create(['name' => 'Old Audits Store']);
            $last = now()->subQuarter();
            OshaAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => $last]);
            BodyShopAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => $last]);
            FinanceAudit::create(['store_id' => $store->id, 'draft' => false, 'audit_date' => $last]);
            DealJacketGroup::create(['uuid' => Str::uuid(), 'store_id' => $store->id, 'completed' => true, 'created_at' => $last]);

            return $store->name;
        });

        Cache::flush();

        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertSee($storeName);
    } finally {
        cleanupDealership($dealership);
    }
});

it('treats draft audits as incomplete', function (): void {
    $admin = makeAdmin();
    $dealership = makeTestDealership($admin);

    try {
        $storeName = $dealership->run(function (): string {
            $store = Store::create(['name' => 'Draft Audits Store']);
            OshaAudit::create(['store_id' => $store->id, 'draft' => true, 'audit_date' => now()]);
            FinanceAudit::create(['store_id' => $store->id, 'draft' => true, 'audit_date' => now()]);
            DealJacketGroup::create(['uuid' => Str::uuid(), 'store_id' => $store->id, 'completed' => false]);

            return $store->name;
        });

        Cache::flush();

        Livewire::actingAs($admin)
            ->test(UpcomingAudits::class)
            ->assertSee($storeName);
    } finally {
        cleanupDealership($dealership);
    }
});

it('renders on the central dashboard', function (): void {
    $admin = makeAdmin();

    $this->actingAs($admin)
        ->get(route('dashboard'))
        ->assertSuccessful()
        ->assertSeeLivewire(UpcomingAudits::class);
});
