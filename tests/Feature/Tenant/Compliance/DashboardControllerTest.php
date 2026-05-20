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
use Spatie\Permission\Models\Role;

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
                ->has('grade')
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

it('passes show_kpi_cards=true for users with executive roles', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('show_kpi_cards', true)
        );
});

it('hides the KPI cards from Managers', function (): void {
    $store = Store::query()->firstOrFail();

    $manager = User::query()->create([
        'name' => 'KPI Manager '.uniqid(),
        'email' => 'kpi-manager-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $manager->assignRole(Role::query()->where('name', 'Manager')->firstOrFail());
    $manager->stores()->attach($store->id);
    $manager->update(['current_store_id' => $store->id]);

    $this->actingAs($manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('show_kpi_cards', false)
        );
});

it('still shows the KPI cards to a Manager who also holds an executive role', function (): void {
    $store = Store::query()->firstOrFail();

    $managerOwner = User::query()->create([
        'name' => 'KPI Manager Owner '.uniqid(),
        'email' => 'kpi-manager-owner-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $managerOwner->assignRole(Role::query()->where('name', 'Manager')->firstOrFail());
    $managerOwner->assignRole(Role::query()->where('name', 'Owner')->firstOrFail());
    $managerOwner->stores()->attach($store->id);
    $managerOwner->update(['current_store_id' => $store->id]);

    $this->actingAs($managerOwner)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('show_kpi_cards', true)
        );
});

it('renders the employee dashboard for users whose only role is Employee', function (): void {
    $store = Store::query()->firstOrFail();

    $employee = User::query()->create([
        'name' => 'Just An Employee '.uniqid(),
        'email' => 'employee-only-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $employee->assignRole(Role::query()->where('name', 'Employee')->firstOrFail());
    $employee->stores()->attach($store->id);

    $this->actingAs($employee)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->component('tenant/EmployeeDashboard')
            ->has('courses')
            ->has('can_issue_dot_certificate')
        );
});

it('renders the employee dashboard for users whose only role is Porter/Driver', function (): void {
    $store = Store::query()->firstOrFail();

    $porter = User::query()->create([
        'name' => 'Porter Only '.uniqid(),
        'email' => 'porter-only-'.uniqid().'@test.com',
        'password' => bcrypt('password'),
    ]);
    $porter->assignRole(Role::query()->where('name', 'Porter/Driver')->firstOrFail());
    $porter->stores()->attach($store->id);

    $this->actingAs($porter)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->component('tenant/EmployeeDashboard')
        );
});

it('passes consultant_note when a Consultant has a current_store_id', function (): void {
    $store = Store::query()->firstOrFail();
    $store->update(['note' => 'Follow up with GM about OSHA findings.']);
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('consultant_note.note', 'Follow up with GM about OSHA findings.')
            ->where('manuals_summary', null)
        );
});

it('passes manuals_summary for non-Consultant users with a current_store_id', function (): void {
    $store = Store::query()->firstOrFail();
    $this->manager->stores()->attach($store->id);
    $this->manager->update(['current_store_id' => $store->id]);

    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->has('manuals_summary', fn (AssertableInertia $manuals): AssertableInertia => $manuals
                ->has('isp')
                ->has('osha')
                ->has('red_flag')
                ->has('cms')
            )
            ->where('consultant_note', null)
        );
});

it('passes audit_quick_start_store_id when a Consultant has a current_store_id', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('audit_quick_start_store_id', $store->id)
        );
});

it('passes audit_quick_start_store_id as null when the Consultant is in multi-store overview mode', function (): void {
    Store::query()->create(['name' => 'Second Store '.uniqid(), 'slug' => 'second-'.uniqid()]);
    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('audit_quick_start_store_id', null)
        );
});

it('passes audit_quick_start_store_id as null for non-Consultant users with a current_store_id', function (): void {
    $store = Store::query()->firstOrFail();
    $this->manager->stores()->attach($store->id);
    $this->manager->update(['current_store_id' => $store->id]);

    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('audit_quick_start_store_id', null)
        );
});

it('flags is_overview when more than one store is in scope', function (): void {
    Store::query()->create(['name' => 'Second Store '.uniqid(), 'slug' => 'second-'.uniqid()]);
    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('is_overview', true)
        );
});

it('clears is_overview when only one store is in scope', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('is_overview', false)
        );
});

it('allows authorized users to download the audit report', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('can_download_audit_report', true)
        );
});

it('forbids the audit-report download for users without an authorized role', function (): void {
    $store = Store::query()->firstOrFail();
    $this->manager->stores()->attach($store->id);
    $this->manager->update(['current_store_id' => $store->id]);

    $this->actingAs($this->manager)
        ->get(route('dealer.dashboard.audit-report'))
        ->assertForbidden();
});

it('returns 404 from audit-type-report when no completed audit exists', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'osha']))
        ->assertNotFound();
});

it('returns 404 from audit-type-report for deal_jacket when no completed group exists', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'deal_jacket']))
        ->assertNotFound();
});

it('rejects audit-type-report requests for unknown types via the route constraint', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get('/dashboard/audit-report/bogus-type')
        ->assertNotFound();
});

it('emits a caption when the score moved relative to last month', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    ComplianceScoreSnapshot::query()->create([
        'store_id' => $store->id,
        'scored_on' => CarbonImmutable::now()->subMonth()->subDays(2)->toDateString(),
        'score' => 50.0,
        'pillars' => [],
        'weights' => [],
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->where('compliance.previous_score', 50)
            ->where('compliance.caption', fn (string $caption): bool => preg_match('/^(Up |Down |Unchanged)/', $caption) === 1)
        );
});

it('omits training_completion, training_compliance_snapshot, and location_grades from the initial render — they are deferred', function (): void {
    Store::query()->create(['name' => 'Second '.uniqid(), 'slug' => 'second-'.uniqid()]);
    $this->consultant->update(['current_store_id' => null]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard'))
        ->assertOk()
        ->assertInertia(fn (AssertableInertia $page): AssertableInertia => $page
            ->missing('training_completion')
            ->missing('training_compliance_snapshot')
            ->missing('location_grades')
        );
});

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
