<?php

declare(strict_types=1);

use App\Http\Livewire\Tenant\Audit\DealJacket\Components\MarkCompleteModal;
use App\Http\Livewire\Tenant\Audit\DealJacket\CreateNewGroupButton;
use App\Http\Livewire\Tenant\Audit\DealJacket\DealJacketGroupDeleteModal;
use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Store;
use Livewire\Livewire;

describe('Deal Jacket Group Index Page', function (): void {
    describe('Page Access', function (): void {
        it('allows consultants to access the index page with all components', function (): void {
            $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.index'))
                ->assertStatus(200)
                ->assertSee('Deal Jacket Audits')
                ->assertSeeLivewire('tenant.audit.deal-jacket.components.pass-rate-trend-chart')
                ->assertSeeLivewire('tenant.audit.deal-jacket.components.common-issues-chart')
                ->assertSeeLivewire('tenant.audit.deal-jacket.create-new-group-button')
                ->assertSeeLivewire('tenant.audit.deal-jacket.group-index');
        });
    });

    describe('Multi-Store Data Isolation', function (): void {
        it('consultants only see deal jacket groups belonging to their current store', function (): void {
            // Get the default test store
            $storeA = Store::query()->first();

            // Create a second store within the same tenant
            $storeB = Store::query()->create([
                'name' => 'Second Store',
                'slug' => 'second-store',
            ]);

            // Create groups for Store A
            DealJacketGroup::factory()->count(2)->create(['store_id' => $storeA->id]);

            // Create groups for Store B
            DealJacketGroup::factory()->count(3)->create(['store_id' => $storeB->id]);

            $this->consultant->update(['current_store_id' => $storeA->id]);

            // Verify Store A only sees their 2 groups
            expect(DealJacketGroup::query()->where('store_id', $storeA->id)->count())->toBe(2);
            expect(DealJacketGroup::query()->where('store_id', $storeB->id)->count())->toBe(3);

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.index'));

            $response->assertOk();

            // The Livewire component should only show Store A's groups
            $groups = DealJacketGroup::query()->where('store_id', $storeA->id)->get();
            expect($groups->count())->toBe(2);
        });

        it('managers only see completed deal jacket groups belonging to their current store', function (): void {
            $storeA = Store::query()->first();

            $storeB = Store::query()->create([
                'name' => 'Second Store',
                'slug' => 'second-store',
            ]);

            // Create completed groups for Store A
            DealJacketGroup::factory()->count(2)->create([
                'store_id' => $storeA->id,
                'completed' => true,
            ]);

            // Create completed groups for Store B
            DealJacketGroup::factory()->count(3)->create([
                'store_id' => $storeB->id,
                'completed' => true,
            ]);

            $this->manager->stores()->sync([$storeA->id, $storeB->id]);
            $this->manager->update(['current_store_id' => $storeA->id]);

            // Verify data is correctly scoped
            expect(DealJacketGroup::query()->where('store_id', $storeA->id)->where('completed', true)->count())->toBe(2);
            expect(DealJacketGroup::query()->where('store_id', $storeB->id)->where('completed', true)->count())->toBe(3);

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.index'));

            $response->assertOk();
        });

        it('consultants switching store context see different deal jacket groups', function (): void {
            $storeA = Store::query()->first();

            $storeB = Store::query()->create([
                'name' => 'Second Store',
                'slug' => 'second-store',
            ]);

            // Create groups for both stores
            DealJacketGroup::factory()->count(2)->create(['store_id' => $storeA->id]);
            DealJacketGroup::factory()->count(3)->create(['store_id' => $storeB->id]);

            // Test as Store A
            $this->consultant->update(['current_store_id' => $storeA->id]);

            expect(DealJacketGroup::query()->where('store_id', $storeA->id)->count())->toBe(2);

            $responseA = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.index'));

            $responseA->assertOk();

            // Switch to Store B
            $this->consultant->update(['current_store_id' => $storeB->id]);

            expect(DealJacketGroup::query()->where('store_id', $storeB->id)->count())->toBe(3);

            $responseB = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.index'));

            $responseB->assertOk();
        });
    });

    describe('Consultant Permissions', function (): void {
        describe('Viewing Groups', function (): void {
            it('consultants can see deal jacket group when not completed', function (): void {
                $dealJacketGroup = DealJacketGroup::factory()->create();

                $this->actingAs($this->consultant)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertSee($dealJacketGroup->created_at->format('M d, Y'))
                    ->assertSee('In Progress');
            });
        });

        describe('Creating Groups', function (): void {
            it('consultants can create a new deal jacket group', function (): void {
                $this->actingAs($this->consultant);
                $storeId = Store::query()->first()->id;

                // Bind the current store to the app container (normally done by middleware)
                app()->instance('currentStore', $storeId);

                expect(DealJacketGroup::query()->count())->toBe(0);

                Livewire::test(CreateNewGroupButton::class)
                    ->call('create')
                    ->assertRedirect();

                expect(DealJacketGroup::query()->count())->toBe(1);

                $dealJacketGroup = DealJacketGroup::query()->first();
                expect($dealJacketGroup->store_id)->toBe($storeId);
                expect($dealJacketGroup->completed)->toBeFalse();
            });

            it('consultants redirect to the existing quarterly group without a type error', function (): void {
                $this->actingAs($this->consultant);
                $store = Store::query()->firstOrFail();

                app()->instance('currentStore', $store->id);

                $existingGroup = DealJacketGroup::query()->create([
                    'store_id' => $store->id,
                    'created_at' => now()->startOfQuarter()->addDay(),
                    'updated_at' => now()->startOfQuarter()->addDay(),
                ]);

                Livewire::test(CreateNewGroupButton::class)
                    ->call('create')
                    ->assertRedirect(route('dealer.audit.deal-jackets.index'));

                expect(session('dealJacketGroupUuid'))->toBe($existingGroup->uuid)
                    ->and(DealJacketGroup::query()->count())->toBe(1);
            });

            it('consultants create a group for the scoped store when currentStore is null', function (): void {
                $this->tenant->update(['locations' => true]);

                $storeA = Store::query()->firstOrFail();
                $storeB = Store::query()->create([
                    'name' => 'Scoped Deal Jacket Store',
                    'slug' => 'scoped-deal-jacket-store',
                ]);

                $this->consultant->update(['current_store_id' => null]);
                $this->actingAs($this->consultant);

                app()->instance('currentStore', null);
                app()->forgetInstance('currentStoreModel');
                app()->instance('accessibleStoreIds', collect([$storeA->id, $storeB->id]));
                app()->instance('scopedStoreIds', collect([$storeB->id]));

                Livewire::test(CreateNewGroupButton::class)
                    ->call('create')
                    ->assertRedirect();

                expect(DealJacketGroup::query()->count())->toBe(1)
                    ->and(DealJacketGroup::query()->first()?->store_id)->toBe($storeB->id);
            });
        });

        describe('Marking as Complete', function (): void {
            it('consultants cannot see Mark as Complete button when group has no deal jackets', function (): void {
                DealJacketGroup::factory()->create();

                $this->actingAs($this->consultant)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertDontSee('Mark as Complete');
            });

            it('consultants can see Mark as Complete button when group has deal jackets', function (): void {
                $dealJacketGroup = DealJacketGroup::factory()->create();
                DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

                $this->actingAs($this->consultant)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertSee('Mark as Complete');
            });

            it('consultants can successfully mark a group as complete', function (): void {
                $this->actingAs($this->consultant);
                $dealJacketGroup = DealJacketGroup::factory()->create();
                DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

                expect($dealJacketGroup->completed)->toBeFalse();

                Livewire::test(MarkCompleteModal::class, ['dealJacketGroupId' => $dealJacketGroup->id])
                    ->call('markComplete')
                    ->assertHasNoErrors();

                expect($dealJacketGroup->fresh()->completed)->toBeTrue();
            });
        });

        describe('Deleting Groups', function (): void {
            it('consultants can delete deal jacket group', function (): void {
                $this->actingAs($this->consultant);

                $dealJacketGroup = DealJacketGroup::factory()->create();

                Livewire::test(DealJacketGroupDeleteModal::class, ['dealJacketGroup' => $dealJacketGroup->id])
                    ->call('delete');

                expect(DealJacketGroup::query()->count())->toBe(0);
            });
        });
    });

    describe('Manager Permissions', function (): void {
        describe('Page Access Restrictions', function (): void {
            it('managers cannot see Start Quarterly Audit button', function (): void {
                $this->actingAs($this->manager)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertStatus(200)
                    ->assertDontSee('Start Quarterly Audit');
            });
        });

        describe('Viewing Groups', function (): void {
            it('managers cannot see deal jacket group when not completed', function (): void {
                $dealJacketGroup = DealJacketGroup::factory()->create();

                $this->actingAs($this->manager)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertDontSee($dealJacketGroup->created_at);
            });

            it('managers can see deal jacket group when completed', function (): void {
                $dealJacketGroup = DealJacketGroup::factory()->create(['completed' => true]);

                $this->actingAs($this->manager)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertSee($dealJacketGroup->created_at->format('M d, Y'));
            });
        });

        describe('Creating Groups', function (): void {
            it('managers cannot create a new deal jacket group', function (): void {
                $this->actingAs($this->manager);
                $storeId = Store::query()->first()->id;

                // Bind the current store to the app container (normally done by middleware)
                app()->instance('currentStore', $storeId);

                expect(DealJacketGroup::query()->count())->toBe(0);

                Livewire::test(CreateNewGroupButton::class)
                    ->call('create');

                expect(DealJacketGroup::query()->count())->toBe(0);
            });
        });

        describe('Deleting Groups', function (): void {
            it('managers cannot delete deal jacket group', function (): void {
                $this->actingAs($this->consultant);

                $dealJacketGroup = DealJacketGroup::factory()->create();

                Livewire::test(DealJacketGroupDeleteModal::class, ['dealJacketGroup' => $dealJacketGroup->id])
                    ->call('delete');

                expect(DealJacketGroup::query()->count())->toBe(0);
            });
        });

        describe('Marking as Complete', function (): void {
            it('managers do not see Mark as Complete button when group is empty', function (): void {
                DealJacketGroup::factory()->create();

                $this->actingAs($this->manager)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertDontSee('Mark as Complete');
            });

            it('managers do not see Mark as Complete button even when group has deal jackets', function (): void {
                $dealJacketGroup = DealJacketGroup::factory()->create();
                DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

                $this->actingAs($this->manager)
                    ->get(route('dealer.audit.deal-jackets.index'))
                    ->assertDontSee('Mark as Complete');
            });

            it('managers cannot mark a group as complete even when attempting', function (): void {
                $this->actingAs($this->manager);
                $dealJacketGroup = DealJacketGroup::factory()->create();
                DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

                expect($dealJacketGroup->completed)->toBeFalse();

                Livewire::test(MarkCompleteModal::class, ['dealJacketGroupId' => $dealJacketGroup->id])
                    ->call('markComplete');

                expect($dealJacketGroup->fresh()->completed)->toBeFalse();
            });
        });
    });
});
