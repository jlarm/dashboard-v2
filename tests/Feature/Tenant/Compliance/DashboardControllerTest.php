<?php

declare(strict_types=1);

use App\Enums\Frequency;
use App\Models\ComplianceScoreSnapshot;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\RemediationSetting;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;

it('passes a compliance prop with score, delta, pillars, and caption to the dashboard', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);
    seedActiveRemediationSetting($store);
    seedCompletedAudit($store, $this->consultant);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->component('tenant/Dashboard')
            ->has('compliance', fn (AssertableInertia $compliance): AssertableInertia => $compliance
                ->has('score')
                ->has('previous_score')
                ->has('delta')
                ->has('pillars')
                ->has('computed_at')
                ->has('caption')
            )
            ->has('overdue_remediations', fn (AssertableInertia $overdue): AssertableInertia => $overdue
                ->has('count')
                ->has('high_severity_count')
                ->has('previous_count')
                ->has('delta_pct')
            )
            ->has('expired_training', fn (AssertableInertia $training): AssertableInertia => $training
                ->has('count')
                ->has('expiring_soon_count')
                ->has('previous_count')
                ->has('delta_pct')
            )
            ->has('critical_vulnerabilities')
            ->has('violations_overview', fn (AssertableInertia $overview): AssertableInertia => $overview
                ->has('monthly', 6)
                ->has('quarterly', 6)
                ->has('yearly', 6)
            )
            ->has('audit_tracker', 1, fn (AssertableInertia $row): AssertableInertia => $row
                ->has('type_key')
                ->has('type_label')
                ->has('last_audit_date')
                ->has('grade')
                ->has('delta_label')
                ->has('status')
                ->has('has_report')
            )
        );
});

it('passes overdue_remediations as null when no scoped store has an active RemediationSetting', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('overdue_remediations', null)
        );
});

it('passes overdue_remediations as null when the RemediationSetting exists but is inactive', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);
    seedActiveRemediationSetting($store, active: false);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('overdue_remediations', null)
        );
});

it('passes audit_tracker as null when no scoped store has a completed audit of any type', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('audit_tracker', null)
        );
});

it('passes critical_vulnerabilities as null when no scoped store has a Cyrisma instance_id', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('critical_vulnerabilities', null)
        );
});

it('reads the expired_training previous_count from the per-store snapshot when one store is in scope', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    ComplianceScoreSnapshot::query()->create([
        'store_id' => $store->id,
        'scored_on' => CarbonImmutable::now()->subMonth()->subDays(2)->toDateString(),
        'score' => 80.0,
        'pillars' => [],
        'weights' => [],
        'expired_training_count' => 5,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('expired_training.previous_count', 5)
        );
});

it('computes overdue_remediations.delta_pct from the prior month snapshot', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);
    seedActiveRemediationSetting($store);

    ComplianceScoreSnapshot::query()->create([
        'store_id' => $store->id,
        'scored_on' => CarbonImmutable::now()->subMonth()->subDays(2)->toDateString(),
        'score' => 80.0,
        'pillars' => [],
        'weights' => [],
        'overdue_count' => 10,
        'overdue_high_severity_count' => 3,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('overdue_remediations.previous_count', 10)
            ->where('overdue_remediations.count', 0)
            ->where('overdue_remediations.delta_pct', -100)
        );
});

it('returns an empty compliance payload when no stores are scoped', function (): void {
    Store::query()->delete();
    app()->instance('scopedStoreIds', collect());

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->component('tenant/Dashboard')
            ->where('compliance.score', null)
            ->where('compliance.pillars', [])
        );
})->skip('requires-store middleware blocks empty-store sessions; cover via unit-level controller test if needed.');

function seedActiveRemediationSetting(Store $store, bool $active = true): RemediationSetting
{
    return RemediationSetting::query()->create([
        'store_id' => $store->id,
        'active' => $active,
        'notifications' => true,
        'frequency' => Frequency::WEEKLY->value,
        'managers' => [],
    ]);
}

function seedCompletedAudit(Store $store, User $user): OshaViolationAudit
{
    return OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $user->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonth(),
        'grade' => 'A',
    ]);
}
