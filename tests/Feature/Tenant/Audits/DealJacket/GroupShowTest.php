<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;

describe('Deal Jacket Group Show Page', function () {
    it('displays the page with empty state and all UI elements for consultants', function () {
        $dealJacketGroup = DealJacketGroup::factory()->create();

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

        $response
            ->assertOk()
            ->assertSee('Back')
            ->assertSee('No data')
            ->assertSee('Add Deal Jacket')
            ->assertSeeLivewire('tenant.audit.deal-jacket.deal-jacket-index')
            ->assertSee("Deal Jackets for Quarter {$dealJacketGroup->created_at->quarter} of {$dealJacketGroup->created_at->year}");
    });

    describe('Consultant Permissions', function () {
        it('can view deal jackets', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            $dealJackets = DealJacket::factory(5)->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            expect($dealJackets->count())->toBe(5);

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response->assertOk();

            $dealJackets->each(function ($dealJacket) use ($response) {
                $response
                    ->assertSee($dealJacket->customer_name)
                    ->assertSee($dealJacket->customer_deal_number)
                    ->assertSee($dealJacket->total_passed)
                    ->assertSee($dealJacket->total_failed)
                    ->assertSee($dealJacket->total_high_risk);
            });
        });

        it('can see View action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('View');
        });

        it('can see Edit action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('Edit');
        });

        it('can see Delete action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('Delete');
        });

        it('can delete a deal jacket', function () {
            $this->actingAs($this->consultant);
            $dealJacketGroup = DealJacketGroup::factory()->create();
            $dealJacket = DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            expect(DealJacket::count())->toBe(1);

            Livewire::test(App\Http\Livewire\Tenant\Audit\DealJacket\DealJacketDeleteModal::class, ['dealJacket' => $dealJacket->id])
                ->call('delete');

            expect(DealJacket::count())->toBe(0);
        });

        it('can see Add Deal Jacket button', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();

            $response = $this->actingAs($this->consultant)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('Add Deal Jacket');
        });
    });

    describe('Manager Permissions', function () {
        it('can view deal jackets', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            $dealJacket = DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee($dealJacket->customer_name);
        });

        it('can see View action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('View');
        });

        it('cannot see Edit action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertDontSee('Edit');
        });

        it('cannot see Delete action', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();
            DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertDontSee('Delete');
        });

        it('cannot delete a deal jacket', function () {
            $this->actingAs($this->manager);
            $dealJacketGroup = DealJacketGroup::factory()->create();
            $dealJacket = DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

            expect(DealJacket::count())->toBe(1);

            Livewire::test(App\Http\Livewire\Tenant\Audit\DealJacket\DealJacketDeleteModal::class, ['dealJacket' => $dealJacket->id])
                ->call('delete');

            expect(DealJacket::count())->toBe(1);
        });

        it('cannot see Add Deal Jacket button', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertDontSee('Add Deal Jacket');
        });

        it('can see Back button', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();

            $response = $this->actingAs($this->manager)
                ->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response
                ->assertOk()
                ->assertSee('Back');
        });
    });

    describe('Unauthorized Access', function () {
        it('prevents access for guests', function () {
            $dealJacketGroup = DealJacketGroup::factory()->create();

            $response = $this->get(route('dealer.audit.deal-jackets.show', $dealJacketGroup));

            $response->assertRedirect();
        });
    });
});
