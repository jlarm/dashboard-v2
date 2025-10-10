<?php

declare(strict_types=1);

use App\Http\Livewire\Central\Contracts\Create;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('component can render', function (): void {
    Livewire::test(Create::class)
        ->assertOk();
});

test('additional locations collection is initialized on mount', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->assertSet('additionalLocations', collect());
});

test('can add additional location', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->call('addLocation')
        ->assertSet('additionalLocations', collect([[
            'name' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'contact_name' => '',
            'contact_title' => '',
            'contact_email' => '',
        ]]));
});

test('can add multiple additional locations', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->call('addLocation')
        ->call('addLocation')
        ->call('addLocation')
        ->assertCount('additionalLocations', 3);
});

test('can remove additional locations by key', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->call('addLocation')
        ->call('addLocation')
        ->call('addLocation')
        ->assertCount('additionalLocations', 3)
        ->call('removeLocation', 1)
        ->assertCount('additionalLocations', 2);
});

test('can create contract with required fields only', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'acme motors')
        ->set('services', ['Service A', 'Service B'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertRedirect();

    $this->assertDatabaseHas('contracts', [
        'contract_type' => 'Standard',
        'agreement_date' => '2025-01-15 00:00:00',
        'dealer_name' => 'Acme Motors',
        'commence_date' => '2025-02-01 00:00:00',
        'yearly_inspection_total' => 12,
        'initial_fee' => 100000,
        'monthly_fee' => 25000,
    ]);
});

test('dealer name is converted to title case', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'acme motors inc')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create');

    $this->assertDatabaseHas('contracts', [
        'dealer_name' => 'Acme Motors Inc',
    ]);
});

test('can create contract with all optional fields', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Premium')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->set('dealerPhysicalAddress', '123 Main St')
        ->set('dealerPhysicalCity', 'Detroit')
        ->set('dealerPhysicalState', 'MI')
        ->set('dealerPhysicalZip', '48201')
        ->set('dealerPhone', '555-1234')
        ->set('dealerQiName', 'John Doe')
        ->set('dealerQiEmail', 'john@example.com')
        ->set('dealerBillingAddress', '456 Billing Ave')
        ->set('dealerBillingCity', 'Ann Arbor')
        ->set('dealerBillingState', 'MI')
        ->set('dealerBillingZip', '48103')
        ->set('dealerBillingFax', '555-5678')
        ->set('dealerBillingContactName', 'Jane Smith')
        ->set('dealerBillingContactTitle', 'CFO')
        ->set('dealerBillingContactEmail', 'jane@example.com')
        ->call('create');

    $this->assertDatabaseHas('contracts', [
        'dealer_physical_address' => '123 Main St',
        'dealer_physical_city' => 'Detroit',
        'dealer_qi_email' => 'john@example.com',
        'dealer_billing_address' => '456 Billing Ave',
    ]);
});

test('can create contract with additional locations', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('addLocation')
        ->set('additionalLocations.0.name', 'Branch Office')
        ->set('additionalLocations.0.address', '789 Oak St')
        ->set('additionalLocations.0.city', 'Lansing')
        ->set('additionalLocations.0.state', 'MI')
        ->set('additionalLocations.0.zip', '48912')
        ->set('additionalLocations.0.contact_name', 'Bob Johnson')
        ->set('additionalLocations.0.contact_title', 'Manager')
        ->set('additionalLocations.0.contact_email', 'bob@example.com')
        ->call('create');

    $contract = Contract::first();
    expect($contract->additional_locations)->toHaveCount(1)
        ->and($contract->additional_locations[0]['name'])->toBe('Branch Office')
        ->and($contract->additional_locations[0]['address'])->toBe('789 Oak St');
});

test('contract status is created with correct data', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create');

    $contract = Contract::first();

    $this->assertDatabaseHas('contract_statuses', [
        'contract_id' => $contract->id,
        'name' => $user->name,
        'status' => 'created contract',
        'step' => 1,
    ]);
});

test('redirects to contract edit page after creation', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertRedirect(route('contracts.edit', Contract::first()));
});

test('contract type is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', '')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['contractType' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('agreement date is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['agreementDate' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('agreement date must be a valid date', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', 'not-a-date')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['agreementDate' => 'date']);

    $this->assertDatabaseCount('contracts', 0);
});

test('dealer name is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', '')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['dealerName' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('services is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', [])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors('services');

    $this->assertDatabaseCount('contracts', 0);
});

test('commence date is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['commenceDate' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('yearly inspection total is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['yearlyInspectionTotal' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('initial fee is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('monthlyFee', 250)
        ->call('create')
        ->assertHasErrors(['initialFee' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('monthly fee is required', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->call('create')
        ->assertHasErrors(['monthlyFee' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('dealer qi email must be valid email when provided', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->set('dealerQiEmail', 'invalid-email')
        ->call('create')
        ->assertHasErrors(['dealerQiEmail' => 'email']);

    $this->assertDatabaseCount('contracts', 0);
});

test('dealer billing contact email must be valid email when provided', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->set('dealerBillingContactEmail', 'not-valid')
        ->call('create')
        ->assertHasErrors(['dealerBillingContactEmail' => 'email']);

    $this->assertDatabaseCount('contracts', 0);
});

test('additional location name is required when location added', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('addLocation')
        ->set('additionalLocations.0.name', '')
        ->set('additionalLocations.0.address', '123 Main')
        ->set('additionalLocations.0.city', 'Detroit')
        ->set('additionalLocations.0.state', 'MI')
        ->set('additionalLocations.0.zip', '48201')
        ->call('create')
        ->assertHasErrors(['additionalLocations.0.name' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('additional location address is required when location added', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('addLocation')
        ->set('additionalLocations.0.name', 'Branch')
        ->set('additionalLocations.0.address', '')
        ->set('additionalLocations.0.city', 'Detroit')
        ->set('additionalLocations.0.state', 'MI')
        ->set('additionalLocations.0.zip', '48201')
        ->call('create')
        ->assertHasErrors(['additionalLocations.0.address' => 'required']);

    $this->assertDatabaseCount('contracts', 0);
});

test('additional location contact email must be valid when provided', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('contractType', 'Standard')
        ->set('agreementDate', '2025-01-15')
        ->set('dealerName', 'Acme Motors')
        ->set('services', ['Service A'])
        ->set('commenceDate', '2025-02-01')
        ->set('yearlyInspectionTotal', 12)
        ->set('initialFee', 1000)
        ->set('monthlyFee', 250)
        ->call('addLocation')
        ->set('additionalLocations.0.name', 'Branch')
        ->set('additionalLocations.0.address', '123 Main')
        ->set('additionalLocations.0.city', 'Detroit')
        ->set('additionalLocations.0.state', 'MI')
        ->set('additionalLocations.0.zip', '48201')
        ->set('additionalLocations.0.contact_email', 'bad-email')
        ->call('create')
        ->assertHasErrors(['additionalLocations.0.contact_email' => 'email']);

    $this->assertDatabaseCount('contracts', 0);
});
