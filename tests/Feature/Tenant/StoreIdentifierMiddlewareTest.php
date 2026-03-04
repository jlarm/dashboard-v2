<?php

declare(strict_types=1);

use App\Http\Middleware\StoreIdentifierMiddleware;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Http\Request;

describe('store identifier middleware', function (): void {
    beforeEach(function (): void {
        $this->tenant->locations = true;
        $this->tenant->save();
    });

    it('binds the users selected store from current_store_id', function (): void {
        $store = Store::query()->firstOrFail();

        $user = User::query()->create([
            'name' => 'Store User',
            'email' => 'store-user@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $store->id,
        ]);
        $user->assignRole('Manager');
        $user->stores()->attach($store->id);

        $request = Request::create('/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = app(StoreIdentifierMiddleware::class)->handle($request, fn () => response('ok'));

        expect($response->getContent())->toBe('ok');
        expect(app('currentStore'))->toBe($store->id);
        expect(app('currentStoreModel')?->id)->toBe($store->id);
        expect(app('accessibleStoreIds')->all())->toBe([$store->id]);
        expect(app('scopedStoreIds')->all())->toBe([$store->id]);
    });

    it('binds the only store as accessible scope when current_store_id is null in a single-store tenant', function (): void {
        $store = Store::query()->firstOrFail();

        $user = User::query()->create([
            'name' => 'Overview User',
            'email' => 'overview-user@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $user->assignRole('Manager');

        $request = Request::create('/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = app(StoreIdentifierMiddleware::class)->handle($request, fn () => response('ok'));

        expect($response->getContent())->toBe('ok');
        expect(app('currentStore'))->toBeNull();
        expect(app()->bound('currentStoreModel'))->toBeFalse();
        expect(app('accessibleStoreIds')->all())->toBe([$store->id]);
        expect(app('scopedStoreIds')->all())->toBe([$store->id]);
    });

    it('auto selects the only accessible store for consultants when current_store_id is null', function (): void {
        $store = Store::query()->firstOrFail();

        $user = User::query()->create([
            'name' => 'Single Store User',
            'email' => 'single-store-user@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => null,
        ]);
        $user->assignRole('Consultant');

        $request = Request::create('/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = app(StoreIdentifierMiddleware::class)->handle($request, fn () => response('ok'));

        expect($response->getContent())->toBe('ok');
        expect($user->fresh()->current_store_id)->toBe($store->id);
        expect(app('currentStore'))->toBe($store->id);
        expect(app('currentStoreModel')?->id)->toBe($store->id);
        expect(app('accessibleStoreIds')->all())->toBe([$store->id]);
        expect(app('scopedStoreIds')->all())->toBe([$store->id]);
    });

    it('clears invalid selected stores for non consultants even when they only have one accessible store', function (): void {
        $assignedStore = Store::query()->firstOrFail();

        $unassignedStore = Store::query()->create([
            'name' => 'Unassigned Store',
            'slug' => 'unassigned-store-'.uniqid(),
            'address' => '99 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user = User::query()->create([
            'name' => 'Invalid Assignment User',
            'email' => 'invalid-assignment@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $unassignedStore->id,
        ]);
        $user->assignRole('Manager');
        $user->stores()->attach($assignedStore->id);

        $request = Request::create('/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = app(StoreIdentifierMiddleware::class)->handle($request, fn () => response('ok'));

        expect($response->getContent())->toBe('ok');
        expect($user->fresh()->current_store_id)->toBeNull();
        expect(app('currentStore'))->toBeNull();
        expect(app()->bound('currentStoreModel'))->toBeFalse();
        expect(app('scopedStoreIds')->all())->toBe([$assignedStore->id]);
    });

    it('clears invalid selected stores when user has multiple accessible stores', function (): void {
        $assignedStoreA = Store::query()->firstOrFail();
        $assignedStoreB = Store::query()->create([
            'name' => 'Assigned Store B',
            'slug' => 'assigned-store-b-'.uniqid(),
            'address' => '100 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $unassignedStore = Store::query()->create([
            'name' => 'Unassigned Store C',
            'slug' => 'unassigned-store-c-'.uniqid(),
            'address' => '101 Main St',
            'city' => 'Springfield',
            'state' => 'IL',
            'postal_code' => '62701',
        ]);

        $user = User::query()->create([
            'name' => 'Invalid Multi Assignment User',
            'email' => 'invalid-multi-assignment@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $unassignedStore->id,
        ]);
        $user->assignRole('Manager');
        $user->stores()->attach([$assignedStoreA->id, $assignedStoreB->id]);

        $request = Request::create('/dashboard');
        $request->setUserResolver(fn () => $user);

        $response = app(StoreIdentifierMiddleware::class)->handle($request, fn () => response('ok'));

        expect($response->getContent())->toBe('ok');
        expect($user->fresh()->current_store_id)->toBeNull();
        expect(app('currentStore'))->toBeNull();
        expect(app()->bound('currentStoreModel'))->toBeFalse();
        expect(app('scopedStoreIds')->all())->toBe([$assignedStoreA->id, $assignedStoreB->id]);
    });
});
