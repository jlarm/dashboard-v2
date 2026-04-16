<?php

declare(strict_types=1);

use App\Enums\ComplianceSummaryFrequency;
use App\Jobs\SendComplianceSummaryJob;
use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;

describe('compliance-summary:send command', function (): void {

    beforeEach(function (): void {
        Bus::fake();
    });

    it('dispatches a single job covering all stores on the first day of the month', function (): void {
        $owner = User::factory()->create(['email' => 'owner@compliance.test']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Monthly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        tenancy()->end();

        $this->travelTo(now()->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertDispatched(SendComplianceSummaryJob::class, 1);
    });

    it('includes all store ids in the dispatched job', function (): void {
        $owner = User::factory()->create(['email' => 'owner2@compliance.test']);
        $owner->assignRole('Owner');

        $secondStore = Store::query()->create(['name' => 'Second Store', 'slug' => 'second-store']);

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Monthly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        $allStoreIds = Store::query()->pluck('id')->sort()->values()->all();

        tenancy()->end();

        $this->travelTo(now()->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertDispatched(SendComplianceSummaryJob::class, fn (SendComplianceSummaryJob $job): bool => collect($job->storeIds)->sort()->values()->all() === $allStoreIds);
    });

    it('does not dispatch when compliance_summary_active is false', function (): void {
        $owner = User::factory()->create(['email' => 'owner3@compliance.test']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => false,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Monthly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        tenancy()->end();

        $this->travelTo(now()->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('does not dispatch on a mid-month day', function (): void {
        $owner = User::factory()->create(['email' => 'owner4@compliance.test']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Monthly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        tenancy()->end();

        // 15th of the month — not the first day
        $this->travelTo(now()->startOfMonth()->addDays(14), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('dispatches on the first day of a quarter-start month', function (): void {
        $owner = User::factory()->create(['email' => 'owner5@compliance.test']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Quarterly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        tenancy()->end();

        // April 1 — first day of Q2, reports on Q1
        $this->travelTo(now()->setMonth(4)->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertDispatched(SendComplianceSummaryJob::class, 1);
    });

    it('does not dispatch on a non-quarter-start first or a non-first day', function (): void {
        $owner = User::factory()->create(['email' => 'owner6@compliance.test']);
        $owner->assignRole('Owner');

        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Quarterly->value,
            'compliance_summary_recipients' => [$owner->id],
        ]);

        tenancy()->end();

        // March 31 — last day of Q1 but NOT the 1st
        $this->travelTo(now()->setMonth(3)->endOfMonth()->startOfDay(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);

        // February 1 — first of month but NOT a quarter-start month
        $this->travelTo(now()->setMonth(2)->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('does not dispatch when no recipients are configured', function (): void {
        GlobalSetting::query()->create([
            'compliance_summary_active' => true,
            'compliance_summary_frequency' => ComplianceSummaryFrequency::Monthly->value,
            'compliance_summary_recipients' => [],
        ]);

        tenancy()->end();

        $this->travelTo(now()->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

    it('does not dispatch when no global setting record exists', function (): void {
        tenancy()->end();

        $this->travelTo(now()->startOfMonth(), function (): void {
            $this->artisan('compliance-summary:send', ['--tenants' => [$this->tenant->id]])
                ->assertSuccessful();
        });

        Bus::assertNotDispatched(SendComplianceSummaryJob::class);
    });

});
