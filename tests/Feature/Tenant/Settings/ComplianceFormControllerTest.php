<?php

declare(strict_types=1);

use App\Models\Dealer\Settings\EmployeeList;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\URL;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
});

function complianceFormUrl(int $storeId): string
{
    return URL::signedRoute('dealer.dealer.settings.form', ['store' => $storeId]);
}

describe('compliance form show', function (): void {
    it('renders the inertia page for a valid signed url', function (): void {
        $this->get(complianceFormUrl($this->store->id))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/ComplianceForm')
                ->where('userSubmitted', false)
                ->where('store.id', $this->store->id)
                ->has('managers')
                ->has('compliance'));
    });

    it('rejects a request without a valid signature', function (): void {
        $this->get(route('dealer.dealer.settings.form', ['store' => $this->store->id]))
            ->assertForbidden();
    });

    it('returns 404 for an unknown store', function (): void {
        $this->get(complianceFormUrl(999999))
            ->assertNotFound();
    });

    it('shows the thank-you state once the form is submitted', function (): void {
        $this->store->update(['user_submitted' => 1]);

        $this->get(complianceFormUrl($this->store->id))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/ComplianceForm')
                ->where('userSubmitted', true));
    });
});

describe('compliance form update', function (): void {
    it('saves the manager and compliance information', function (): void {
        $this->post(complianceFormUrl($this->store->id), [
            'qualified_individual_name' => 'Jane QI',
            'qualified_individual_phone' => '555-111-2222',
            'owner_name' => 'Sam Owner',
            'fire_alarm_type' => 'ADT',
            'mfa' => '1',
            'reinsurance' => true,
            'ip_addresses' => ['10.0.0.1', '10.0.0.2'],
            'service_contracts' => ['Contract A'],
            'fi_username' => 'fi-user',
            'fi_password' => 'secret-pass',
        ])->assertRedirect();

        $store = $this->store->fresh();
        expect($store->fire_alarm_type)->toBe('ADT')
            ->and((string) $store->mfa)->toBe('1')
            ->and($store->ip_addresses)->toBe(['10.0.0.1', '10.0.0.2'])
            ->and($store->service_contracts)->toBe(['Contract A'])
            ->and($store->fi_password)->toBe('secret-pass');

        $managers = EmployeeList::query()->where('store_id', $this->store->id)->firstOrFail();
        expect($managers->qualified_individual_name)->toBe('Jane QI')
            ->and($managers->owner_name)->toBe('Sam Owner');

        $this->get(complianceFormUrl($this->store->id))
            ->assertInertia(fn ($page) => $page->where('userSubmitted', true));
    });

    it('rejects an update without a valid signature', function (): void {
        $this->post(route('dealer.dealer.settings.form.update', ['store' => $this->store->id]), [
            'fire_alarm_type' => 'Should not save',
        ])->assertForbidden();

        expect($this->store->fresh()->fire_alarm_type)->toBeNull();
    });

    it('ignores a resubmission once the form is already submitted', function (): void {
        $this->store->update(['user_submitted' => 1, 'fire_alarm_type' => 'Original']);

        $this->post(complianceFormUrl($this->store->id), [
            'fire_alarm_type' => 'Changed',
        ])->assertRedirect();

        expect($this->store->fresh()->fire_alarm_type)->toBe('Original');
    });
});

describe('compliance info pdf view', function (): void {
    it('renders the downloadable compliance view as plain blade', function (): void {
        $html = view('dealer.settings.ComplianceInfoDownloadView', ['store' => $this->store])->render();

        expect($html)->toContain((string) $this->store->name);
    });
});
