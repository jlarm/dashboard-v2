<?php

declare(strict_types=1);

use App\Enums\ComplianceSummaryFrequency;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('automated reports index', function (): void {
    it('renders the inertia page for super-admin', function (): void {
        $this->consultant->syncRoles('super-admin');

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/settings/AutomatedReports')
                ->has('settings')
                ->has('availableRecipients')
                ->has('frequencies', 2));
    });

    it('renders for qualifying roles', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/settings/AutomatedReports'));
    })->with(['Admin', 'Consultant', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual']);

    it('forbids non-qualifying roles', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports.index'))
            ->assertForbidden();
    })->with(['Manager', 'Employee', 'Porter/Driver']);

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.settings.automated-reports.index'))
            ->assertRedirect(route('dealer.login'));
    });

    it('hydrates existing compliance summary settings', function (): void {
        $owner = User::factory()->create(['email' => 'pre-existing@test.com']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => 'quarterly',
            'compliance_summary_recipients' => [$owner->id],
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports.index'))
            ->assertInertia(fn ($page) => $page
                ->where('settings.compliance_summary_active', true)
                ->where('settings.compliance_summary_frequency', 'quarterly')
                ->where('settings.compliance_summary_recipients', [$owner->id]));
    });

    it('lists qualifying recipients only', function (): void {
        $owner = User::factory()->create(['name' => 'Alice Owner', 'email' => 'alice@test.com']);
        $owner->assignRole('Owner');

        $consultant = User::factory()->create(['name' => 'Carol Consultant', 'email' => 'carol@test.com']);
        $consultant->assignRole('Consultant');

        $employee = User::factory()->create(['name' => 'Bob Employee', 'email' => 'bob@test.com']);
        $employee->assignRole('Employee');

        $this->actingAs($this->consultant)
            ->get(route('dealer.settings.automated-reports.index'))
            ->assertInertia(function ($page) use ($owner): void {
                $names = collect($page->toArray()['props']['availableRecipients'])->pluck('name');

                expect($names)
                    ->toContain($owner->name)
                    ->not->toContain('Carol Consultant')
                    ->not->toContain('Bob Employee');
            });
    });
});

describe('automated reports update', function (): void {
    it('saves compliance summary settings', function (): void {
        $owner = User::factory()->create(['email' => 'owner@test.com']);
        $owner->assignRole('Owner');

        $this->actingAs($this->consultant)
            ->patch(route('dealer.settings.automated-reports.update'), [
                'compliance_summary_active' => true,
                'compliance_summary_frequency' => 'quarterly',
                'compliance_summary_recipients' => [$owner->id],
            ])
            ->assertRedirect();

        $settings = GlobalSetting::query()->firstOrFail();
        expect($settings->compliance_summary_active)->toBeTrue();
        expect($settings->compliance_summary_frequency)->toBe(ComplianceSummaryFrequency::Quarterly);
        expect($settings->compliance_summary_recipients)->toBe([$owner->id]);
    });

    it('requires at least one recipient when active', function (): void {
        $this->actingAs($this->consultant)
            ->patch(route('dealer.settings.automated-reports.update'), [
                'compliance_summary_active' => true,
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [],
            ])
            ->assertSessionHasErrors('compliance_summary_recipients');

        expect(GlobalSetting::query()->first())->toBeNull();
    });

    it('allows saving with active false and no recipients', function (): void {
        $this->actingAs($this->consultant)
            ->patch(route('dealer.settings.automated-reports.update'), [
                'compliance_summary_active' => false,
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [],
            ])
            ->assertRedirect();

        expect(GlobalSetting::query()->firstOrFail()->compliance_summary_active)->toBeFalse();
    });

    it('rejects invalid frequencies', function (): void {
        $this->actingAs($this->consultant)
            ->patch(route('dealer.settings.automated-reports.update'), [
                'compliance_summary_active' => false,
                'compliance_summary_frequency' => 'weekly',
                'compliance_summary_recipients' => [],
            ])
            ->assertSessionHasErrors('compliance_summary_frequency');
    });

    it('forbids managers from saving', function (): void {
        $this->actingAs($this->manager)
            ->patch(route('dealer.settings.automated-reports.update'), [
                'compliance_summary_active' => false,
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [],
            ])
            ->assertForbidden();
    });
});

describe('automated reports send now', function (): void {
    it('dispatches the job for all stores when recipients are selected', function (): void {
        Bus::fake();

        $owner = User::factory()->create(['email' => 'owner.now@test.com']);
        $owner->assignRole('Owner');

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.automated-reports.send'), [
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [$owner->id],
            ])
            ->assertRedirect();

        Bus::assertDispatched(SendComplianceSummaryJob::class, 1);
    });

    it('does not dispatch when no recipients are selected', function (): void {
        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.settings.automated-reports.send'), [
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [],
            ])
            ->assertRedirect();

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('forbids managers from sending', function (): void {
        Bus::fake();

        $owner = User::factory()->create(['email' => 'owner.forbid@test.com']);
        $owner->assignRole('Owner');

        $this->actingAs($this->manager)
            ->post(route('dealer.settings.automated-reports.send'), [
                'compliance_summary_frequency' => 'monthly',
                'compliance_summary_recipients' => [$owner->id],
            ])
            ->assertForbidden();

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });
});
