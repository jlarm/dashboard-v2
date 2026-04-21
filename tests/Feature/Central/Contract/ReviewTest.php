<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Notifications\ContractSignedNotification;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contract_statuses')->truncate();
    DB::table('contracts')->truncate();
    DB::table('model_has_roles')->truncate();
    DB::table('model_has_permissions')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->seed(RoleAndPermissionSeeder::class);
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

    Storage::fake('armpcon');
});

function validReviewPayload(array $overrides = []): array
{
    return array_merge([
        'dealer_physical_address' => '123 Main St',
        'dealer_physical_city' => 'Springfield',
        'dealer_physical_state' => 'IL',
        'dealer_physical_zip' => '62704',
        'dealer_phone' => '555-123-4567',
        'dealer_qi_name' => 'Alice QI',
        'dealer_qi_email' => 'alice@example.com',
        'dealer_billing_address' => '456 Elm St',
        'dealer_billing_city' => 'Springfield',
        'dealer_billing_state' => 'IL',
        'dealer_billing_zip' => '62704',
        'dealer_billing_contact_name' => 'Bob Billing',
        'dealer_billing_contact_title' => 'CFO',
        'dealer_billing_contact_email' => 'bob@example.com',
        'dealer_printed_name' => 'Bob Dealer',
        'dealer_signature' => 'data:image/png;base64,'.base64_encode('dealer-signature-bytes'),
    ], $overrides);
}

it('rejects unsigned URLs on the review page', function (): void {
    $contract = Contract::factory()->create(['dealer_signature' => null]);

    $this->get(route('contracts.show', $contract))->assertForbidden();
});

it('renders the review page via a signed URL', function (): void {
    $contract = Contract::factory()->create([
        'dealer_signature' => null,
        'dealer_printed_name' => null,
    ]);

    $signed = URL::temporarySignedRoute('contracts.show', now()->addHour(), ['contract' => $contract->uuid]);

    $this->get($signed)
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('contract/Review'));
});

it('redirects to thank-you when the contract is already signed', function (): void {
    $contract = Contract::factory()->create([
        'dealer_signature' => 'signed-path.png',
        'dealer_printed_name' => 'Bob Dealer',
    ]);

    $signed = URL::temporarySignedRoute('contracts.show', now()->addHour(), ['contract' => $contract->uuid]);

    $this->get($signed)->assertRedirect(route('contracts.thank-you'));
});

it('stores the dealer signature and appends step 3 on submission', function (): void {
    Notification::fake();

    $contract = Contract::factory()->create([
        'dealer_signature' => null,
        'dealer_printed_name' => null,
    ]);

    $signed = URL::temporarySignedRoute('contracts.show', now()->addHour(), ['contract' => $contract->uuid]);

    $this->post($signed, validReviewPayload())
        ->assertRedirect(route('contracts.thank-you'));

    $contract->refresh();

    expect($contract->dealer_signature)->not->toBeNull()
        ->and($contract->dealer_printed_name)->toBe('Bob Dealer')
        ->and($contract->dealer_date_signed)->not->toBeNull()
        ->and($contract->status()->where('step', 3)->exists())->toBeTrue();

    Storage::disk('armpcon')->assertExists($contract->dealer_signature);

    Notification::assertSentOnDemand(ContractSignedNotification::class);
});

it('blocks re-submission once the contract has been signed', function (): void {
    $contract = Contract::factory()->create([
        'dealer_signature' => 'already-signed.png',
        'dealer_printed_name' => 'Bob Dealer',
    ]);

    $signed = URL::temporarySignedRoute('contracts.show', now()->addHour(), ['contract' => $contract->uuid]);

    $this->post($signed, validReviewPayload())
        ->assertRedirect(route('contracts.thank-you'));
});
