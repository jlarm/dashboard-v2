<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\DealJacket;
use App\Models\Dealer\Audit\DealJacketGroup;

describe('Deal Jacket Show Page', function () {
    it('consultants can see the deal jacket page with all details', function () {
        $dealJacketGroup = DealJacketGroup::factory()->create();
        $dealJacket = DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.audit.deal-jackets.single', [
                'dealJacketGroup' => $dealJacketGroup,
                'dealJacket' => $dealJacket,
            ]));

        $response
            ->assertOk()
            ->assertSee("Deal Jacket Audit for {$dealJacket->customer_name}")
            ->assertSee('Back')
            ->assertSee('Violations')
            ->assertSee('Pass Rate')
            ->assertSee("{$dealJacket->percentage}%")
            ->assertSee($dealJacket->customer_name)
            ->assertSee($dealJacket->customer_deal_number)
            ->assertSee($dealJacket->date_of_deal_jacket->format('M d, Y'))
            ->assertSee(Str::title($dealJacket->purchase_type))
            ->assertSee(Str::title($dealJacket->vehicle_type))
            ->assertSee($dealJacket->mileage)
            ->assertSee(Str::title($dealJacket->user->name));
    });

    it('consultants can see violations with comments', function () {
        $dealJacketGroup = DealJacketGroup::factory()->create();

        // Create a deal jacket with specific responses
        $responses = [
            [
                'statement' => 'Was the customer provided with a copy of the contract?',
                'answer' => 'no',
                'high_risk' => false,
                'comment' => 'Customer refused to sign',
            ],
            [
                'statement' => 'Was the VIN number verified?',
                'answer' => 'no',
                'high_risk' => true,
                'comment' => 'VIN not matching',
            ],
            [
                'statement' => 'Was the odometer reading documented?',
                'answer' => 'yes',
                'high_risk' => false,
                'comment' => null,
            ],
        ];

        $dealJacket = DealJacket::factory()->create([
            'deal_jacket_group_id' => $dealJacketGroup->id,
            'responses' => $responses,
            'total_passed' => 1,
            'total_failed' => 2,
            'total_high_risk' => 1,
            'percentage' => 33,
        ]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.audit.deal-jackets.single', [
                'dealJacketGroup' => $dealJacketGroup,
                'dealJacket' => $dealJacket,
            ]));

        // Should see violations (answer = 'no')
        $response
            ->assertOk()
            ->assertSee('Was the customer provided with a copy of the contract?')
            ->assertSee('Customer refused to sign')
            ->assertSee('Was the VIN number verified?')
            ->assertSee('VIN not matching')
            ->assertSee('High Risk');

        // Should NOT see passed items (answer = 'yes')
        $response->assertDontSee('Was the odometer reading documented?');
    });

    it('managers can see the deal jacket page with all details', function () {
        $dealJacketGroup = DealJacketGroup::factory()->create();
        $dealJacket = DealJacket::factory()->create(['deal_jacket_group_id' => $dealJacketGroup->id]);

        $response = $this->actingAs($this->manager)
            ->get(route('dealer.audit.deal-jackets.single', [
                'dealJacketGroup' => $dealJacketGroup,
                'dealJacket' => $dealJacket,
            ]));

        $response
            ->assertOk()
            ->assertSee("Deal Jacket Audit for {$dealJacket->customer_name}")
            ->assertSee("{$dealJacket->percentage}%")
            ->assertSee($dealJacket->customer_name)
            ->assertSee($dealJacket->customer_deal_number);
    });
});
