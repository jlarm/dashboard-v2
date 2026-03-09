<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Audit\DealJacket\Form;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use App\Models\User;
use Livewire\Livewire;

describe('deal jacket form', function (): void {
    it('returns only finance managers for the current store', function (): void {
        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Other Finance Store',
            'slug' => 'other-finance-store',
        ]);

        $group = DealJacketGroup::query()->create([
            'store_id' => $storeA->id,
        ]);

        $storeAManager = User::query()->create([
            'name' => 'Store A Finance Manager',
            'email' => 'store-a-finance-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => 6,
        ]);
        $storeAManager->assignRole('Manager');
        $storeAManager->stores()->attach($storeA->id);

        $storeBManager = User::query()->create([
            'name' => 'Store B Finance Manager',
            'email' => 'store-b-finance-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => 6,
        ]);
        $storeBManager->assignRole('Manager');
        $storeBManager->stores()->attach($storeB->id);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', $storeA->id);

        $managers = Livewire::test(Form::class, ['dealJacketGroup' => $group])
            ->instance()
            ->managers();

        expect(collect($managers)->pluck('id')->all())->toBe([$storeAManager->id]);
    });

    it('falls back to the deal jacket groups store when currentStore is unavailable', function (): void {
        $storeA = Store::query()->firstOrFail();
        $storeB = Store::query()->create([
            'name' => 'Fallback Finance Store',
            'slug' => 'fallback-finance-store',
        ]);

        $group = DealJacketGroup::query()->create([
            'store_id' => $storeB->id,
        ]);

        $storeAManager = User::query()->create([
            'name' => 'Fallback Store A Manager',
            'email' => 'fallback-store-a-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => 6,
        ]);
        $storeAManager->assignRole('Manager');
        $storeAManager->stores()->attach($storeA->id);

        $storeBManager = User::query()->create([
            'name' => 'Fallback Store B Manager',
            'email' => 'fallback-store-b-manager@test.com',
            'password' => bcrypt('password'),
            'department_id' => 6,
        ]);
        $storeBManager->assignRole('Manager');
        $storeBManager->stores()->attach($storeB->id);

        $this->actingAs($this->consultant);
        app()->instance('currentStore', null);
        app()->forgetInstance('currentStoreModel');

        $component = Livewire::test(Form::class, ['dealJacketGroup' => $group]);
        $managers = $component->instance()->managers();

        expect($component->instance()->store->id)->toBe($storeB->id)
            ->and(collect($managers)->pluck('id')->all())->toBe([$storeBManager->id]);
    });
});
