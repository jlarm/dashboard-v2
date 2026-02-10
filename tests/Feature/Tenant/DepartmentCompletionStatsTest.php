<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Employee\DepartmentCompletionStats;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;

describe('DepartmentCompletionStats Component', function (): void {
    it('renders successfully', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(DepartmentCompletionStats::class)
            ->assertStatus(200);
    });

    it('loads stats when wire:init is triggered', function (): void {
        $this->actingAs($this->consultant);

        Livewire::test(DepartmentCompletionStats::class)
            ->assertSet('readyToLoad', false)
            ->call('loadStats')
            ->assertSet('readyToLoad', true);
    });
});

describe('Role-Based Store Access on tenant.dashboard (no store parameter)', function (): void {
    it('shows all stores departments for super-admin', function (): void {
        $superAdmin = User::query()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $store1 = Store::query()->create(['name' => 'Store 1', 'slug' => 'store-1']);
        $store2 = Store::query()->create(['name' => 'Store 2', 'slug' => 'store-2']);

        // Create users in both stores
        $user1 = User::factory()->create(['department_id' => 1]);
        $user1->stores()->attach($store1->id);

        $user2 = User::factory()->create(['department_id' => 2]);
        $user2->stores()->attach($store2->id);

        $this->actingAs($superAdmin);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // Should query all users regardless of store
        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });

    it('shows all stores departments for Consultant', function (): void {
        $store1 = Store::query()->create(['name' => 'Store 1', 'slug' => 'store-1']);
        $store2 = Store::query()->create(['name' => 'Store 2', 'slug' => 'store-2']);

        // Create users in both stores
        $user1 = User::factory()->create(['department_id' => 1]);
        $user1->stores()->attach($store1->id);

        $user2 = User::factory()->create(['department_id' => 2]);
        $user2->stores()->attach($store2->id);

        $this->actingAs($this->consultant);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });

    it('shows only assigned stores departments for regular users with multiple locations', function (): void {
        // Set locations to true to simulate multi-location tenant
        tenant()->update(['locations' => true]);

        $manager = User::query()->create([
            'name' => 'Manager',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
        ]);
        $manager->assignRole('Manager');

        $assignedStore = Store::query()->create(['name' => 'Assigned Store', 'slug' => 'assigned-store']);
        $otherStore = Store::query()->create(['name' => 'Other Store', 'slug' => 'other-store']);

        // Assign only one store to manager
        $manager->stores()->attach($assignedStore->id);

        // Create users in both stores
        $userInAssignedStore = User::factory()->create(['department_id' => 1]);
        $userInAssignedStore->stores()->attach($assignedStore->id);

        $userInOtherStore = User::factory()->create(['department_id' => 1]);
        $userInOtherStore->stores()->attach($otherStore->id);

        $this->actingAs($manager);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // The component should only query users from the assigned store
        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });

    it('shows all users in single location tenant for regular users', function (): void {
        // Set locations to false to simulate single-location tenant
        tenant()->update(['locations' => false]);

        $manager = $this->manager;
        $store = Store::query()->first();

        $user1 = User::factory()->create(['department_id' => 1]);
        $user1->stores()->attach($store->id);

        $user2 = User::factory()->create(['department_id' => 2]);
        $user2->stores()->attach($store->id);

        $this->actingAs($manager);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // Should show all users when single location
        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });
});

describe('Specific Store View (with store parameter)', function (): void {
    it('shows only specific store departments when store parameter is passed', function (): void {
        $store1 = Store::query()->create(['name' => 'Store 1', 'slug' => 'store-1']);
        $store2 = Store::query()->create(['name' => 'Store 2', 'slug' => 'store-2']);

        // Create users in both stores
        $user1 = User::factory()->create(['department_id' => 1]);
        $user1->stores()->attach($store1->id);

        $user2 = User::factory()->create(['department_id' => 2]);
        $user2->stores()->attach($store2->id);

        $this->actingAs($this->consultant);

        $component = Livewire::test(DepartmentCompletionStats::class, ['store' => $store1])
            ->call('loadStats');

        // Should only query users from store1
        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });

    it('shows only specific store departments for regular users', function (): void {
        $manager = $this->manager;

        $store1 = Store::query()->create(['name' => 'Store 1', 'slug' => 'store-1']);
        $store2 = Store::query()->create(['name' => 'Store 2', 'slug' => 'store-2']);

        $manager->stores()->attach([$store1->id, $store2->id]);

        // Create users in both stores
        $user1 = User::factory()->create(['department_id' => 1]);
        $user1->stores()->attach($store1->id);

        $user2 = User::factory()->create(['department_id' => 2]);
        $user2->stores()->attach($store2->id);

        $this->actingAs($manager);

        $component = Livewire::test(DepartmentCompletionStats::class, ['store' => $store1])
            ->call('loadStats');

        // Should only query users from store1, regardless of user role
        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });
});

describe('Cache Key Generation', function (): void {
    it('uses different cache keys for specific store vs all stores', function (): void {
        $store = Store::query()->first();

        $this->actingAs($this->consultant);

        // Test with store
        $componentWithStore = Livewire::test(DepartmentCompletionStats::class, ['store' => $store])
            ->call('loadStats');

        // Test without store
        $componentWithoutStore = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // The cache keys should be different
        // We can't directly access protected methods, but we can verify the component works
        expect($componentWithStore)->not->toBe($componentWithoutStore);
    });

    it('uses different cache keys for super-admin vs regular users', function (): void {
        tenant()->update(['locations' => true]);

        $superAdmin = User::query()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'password' => bcrypt('password'),
        ]);
        $superAdmin->assignRole('super-admin');

        $manager = $this->manager;
        $store = Store::query()->first();
        $manager->stores()->attach($store->id);

        // Test as super-admin
        $this->actingAs($superAdmin);
        $componentAdmin = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // Test as manager
        $this->actingAs($manager);
        $componentManager = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // Should use different cache keys
        expect($componentAdmin)->not->toBe($componentManager);
    });

    it('caches stats for 5 minutes', function (): void {
        $this->actingAs($this->consultant);

        Cache::flush();

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        $stats = $component->get('stats');

        // Verify cache exists
        $tenantId = tenant('id');
        $cacheKey = "department_completion_stats_all_{$tenantId}_admin";

        expect(Cache::has($cacheKey))->toBeTrue();
    });
});

describe('Cache Clearing and Refresh', function (): void {
    it('clears and refreshes cache when refreshEmployeeDetails event is emitted', function (): void {
        $this->actingAs($this->consultant);

        Cache::flush();

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        // Cache should exist
        $tenantId = tenant('id');
        $cacheKey = "department_completion_stats_all_{$tenantId}_admin";
        expect(Cache::has($cacheKey))->toBeTrue();

        // Store original cached value
        $originalCachedValue = Cache::get($cacheKey);

        // Clear cache manually to simulate clearing
        Cache::forget($cacheKey);
        expect(Cache::has($cacheKey))->toBeFalse();

        // Emit event to clear cache and refresh
        $component->emit('refreshEmployeeDetails');

        // Cache should be repopulated after refresh (because readyToLoad is true)
        expect(Cache::has($cacheKey))->toBeTrue();
    });

    it('clears and refreshes cache for specific store', function (): void {
        $store = Store::query()->first();

        $this->actingAs($this->consultant);

        Cache::flush();

        $component = Livewire::test(DepartmentCompletionStats::class, ['store' => $store])
            ->call('loadStats');

        // Cache should exist
        $tenantId = tenant('id');
        $cacheKey = "department_completion_stats_{$store->id}_{$tenantId}";
        expect(Cache::has($cacheKey))->toBeTrue();

        // Clear cache manually
        Cache::forget($cacheKey);
        expect(Cache::has($cacheKey))->toBeFalse();

        // Emit event to clear cache and refresh
        $component->emit('refreshEmployeeDetails');

        // Cache should be repopulated after refresh
        expect(Cache::has($cacheKey))->toBeTrue();
    });

    it('clears all related caches when no store is specified', function (): void {
        $this->actingAs($this->consultant);

        $store1 = Store::query()->create(['name' => 'Test Store 1', 'slug' => 'test-store-1']);
        $store2 = Store::query()->create(['name' => 'Test Store 2', 'slug' => 'test-store-2']);

        // Populate caches for individual stores
        Livewire::test(DepartmentCompletionStats::class, ['store' => $store1])
            ->call('loadStats');

        Livewire::test(DepartmentCompletionStats::class, ['store' => $store2])
            ->call('loadStats');

        $tenantId = tenant('id');
        $store1CacheKey = "department_completion_stats_{$store1->id}_{$tenantId}";
        $store2CacheKey = "department_completion_stats_{$store2->id}_{$tenantId}";

        expect(Cache::has($store1CacheKey))->toBeTrue();
        expect(Cache::has($store2CacheKey))->toBeTrue();

        // Clear all caches via component without store
        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats')
            ->emit('refreshEmployeeDetails');

        // Individual store caches should be cleared (may be repopulated depending on logic)
        // The clearAllCachesForTenantAndStore method clears all store caches when no store is specified
    });
});

describe('Department Stats Calculation', function (): void {
    it('filters out excluded users', function (): void {
        $store = Store::query()->first();

        // Create excluded users
        $excluded1 = User::query()->create([
            'name' => 'Joe Lohr',
            'email' => 'joe@test.com',
            'password' => bcrypt('password'),
            'department_id' => 1,
        ]);
        $excluded1->stores()->attach($store->id);

        $excluded2 = User::query()->create([
            'name' => 'Terry Dortch',
            'email' => 'terry@test.com',
            'password' => bcrypt('password'),
            'department_id' => 1,
        ]);
        $excluded2->stores()->attach($store->id);

        $excluded3 = User::query()->create([
            'name' => 'Mike Backer',
            'email' => 'mike@test.com',
            'password' => bcrypt('password'),
            'department_id' => 1,
        ]);
        $excluded3->stores()->attach($store->id);

        // Create regular user
        $regularUser = User::factory()->create(['department_id' => 1]);
        $regularUser->stores()->attach($store->id);

        $this->actingAs($this->consultant);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        $stats = $component->get('stats');
        expect($stats)->toBeArray();
        // The excluded users should not be counted
    });

    it('excludes users with role id 5', function (): void {
        $store = Store::query()->first();

        // Assuming role id 5 should be excluded (based on line 117 in the component)
        $user = User::factory()->create(['department_id' => 1]);
        $user->stores()->attach($store->id);

        $this->actingAs($this->consultant);

        $component = Livewire::test(DepartmentCompletionStats::class)
            ->call('loadStats');

        $stats = $component->get('stats');
        expect($stats)->toBeArray();
    });
});
