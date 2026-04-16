<?php

declare(strict_types=1);

use App\Enums\ComplianceSummaryFrequency;
use App\Http\Livewire\Dealer\Settings\AutomatedReports;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;

describe('automated reports settings', function (): void {

    it('renders the automated reports page for super-admin', function (): void {
        $this->consultant->syncRoles('super-admin');

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports'))
            ->assertOk()
            ->assertSeeLivewire(AutomatedReports::class);
    });

    it('renders the automated reports page for qualifying roles', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports'))
            ->assertOk()
            ->assertSeeLivewire(AutomatedReports::class);
    })->with(['Consultant', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']);

    it('is inaccessible to roles without access', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports'))
            ->assertForbidden();
    })->with(['Manager', 'Employee', 'Porter/Driver']);

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.settings.automated-reports'))
            ->assertRedirect(route('dealer.login'));
    });

    it('loads existing compliance summary settings on mount', function (): void {
        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => 'monthly',
            'compliance_summary_recipients' => [999],
        ]);

        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->assertSet('compliance_summary_active', true)
            ->assertSet('compliance_summary_frequency', 'monthly')
            ->assertSet('compliance_summary_recipients', [999]);
    });

    it('saves compliance summary settings', function (): void {
        $owner = User::factory()->create(['email' => 'owner@test.com']);
        $owner->assignRole('Owner');

        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_active', true)
            ->set('compliance_summary_frequency', 'quarterly')
            ->set('compliance_summary_recipients', [$owner->id])
            ->call('saveComplianceSummary')
            ->assertHasNoErrors();

        $settings = GlobalSetting::query()->first();
        expect($settings->compliance_summary_active)->toBeTrue();
        expect($settings->compliance_summary_frequency)->toBe(ComplianceSummaryFrequency::Quarterly);
        expect($settings->compliance_summary_recipients)->toBe([$owner->id]);
    });

    it('requires at least one recipient when active', function (): void {
        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_active', true)
            ->set('compliance_summary_frequency', 'monthly')
            ->set('compliance_summary_recipients', [])
            ->call('saveComplianceSummary')
            ->assertHasErrors(['compliance_summary_recipients']);
    });

    it('allows saving with active false and no recipients', function (): void {
        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_active', false)
            ->set('compliance_summary_frequency', 'monthly')
            ->set('compliance_summary_recipients', [])
            ->call('saveComplianceSummary')
            ->assertHasNoErrors();

        expect(GlobalSetting::query()->first()->compliance_summary_active)->toBeFalse();
    });

    it('requires a valid frequency', function (): void {
        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_active', false)
            ->set('compliance_summary_frequency', 'weekly')
            ->call('saveComplianceSummary')
            ->assertHasErrors(['compliance_summary_frequency']);
    });

    it('shows qualifying users as available recipients but not consultants', function (): void {
        $owner = User::factory()->create(['name' => 'Alice Owner', 'email' => 'alice@test.com']);
        $owner->assignRole('Owner');

        $consultant = User::factory()->create(['name' => 'Carol Consultant', 'email' => 'carol@test.com']);
        $consultant->assignRole('Consultant');

        $employee = User::factory()->create(['name' => 'Bob Employee', 'email' => 'bob@test.com']);
        $employee->assignRole('Employee');

        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->assertSee('Alice Owner')
            ->assertDontSee('Carol Consultant')
            ->assertDontSee('Bob Employee');
    });

    it('dispatches jobs for all stores when sendNow is called with recipients selected', function (): void {
        Bus::fake();

        $owner = User::factory()->create(['email' => 'owner.now@test.com']);
        $owner->assignRole('Owner');

        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_frequency', 'monthly')
            ->set('compliance_summary_recipients', [$owner->id])
            ->call('sendNow')
            ->assertHasNoErrors();

        Bus::assertDispatched(SendComplianceSummaryJob::class, 1);
    });

    it('does not dispatch when sendNow is called with no recipients', function (): void {
        Bus::fake();

        $this->consultant->syncRoles('super-admin');

        Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_recipients', [])
            ->call('sendNow')
            ->assertHasNoErrors();

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('forbids saveComplianceSummary for unauthorized roles', function (): void {
        // Mount as super-admin (which is allowed), then downgrade the user before calling the method.
        $this->consultant->syncRoles('super-admin');

        $component = Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class);

        $this->consultant->syncRoles('Manager');

        $component
            ->set('compliance_summary_active', true)
            ->set('compliance_summary_frequency', 'monthly')
            ->call('saveComplianceSummary')
            ->assertForbidden();

        expect(GlobalSetting::query()->first())->toBeNull();
    });

    it('forbids sendNow for unauthorized roles', function (): void {
        Bus::fake();

        $owner = User::factory()->create(['email' => 'owner.forbidden@test.com']);
        $owner->assignRole('Owner');

        $this->consultant->syncRoles('super-admin');

        $component = Livewire::actingAs($this->consultant)
            ->test(AutomatedReports::class)
            ->set('compliance_summary_recipients', [$owner->id]);

        $this->consultant->syncRoles('Manager');

        $component
            ->call('sendNow')
            ->assertForbidden();

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

});
