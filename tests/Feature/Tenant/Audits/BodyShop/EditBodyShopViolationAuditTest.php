<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Remediation;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->actingAs($this->consultant);

    $this->audit = BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-13',
    ]);
});

it('summarises the previous completed audit, unresolved issues first', function (): void {
    $previous = BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
        'grade' => 'B',
        'completed_date' => '2026-03-15',
    ]);

    $previous->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Spray booth filters overdue.',
        'comment' => 'Filters past service interval.',
        'risk' => true,
        'severity' => 8,
    ]);

    $resolved = $previous->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 2,
        'statement' => 'Mixing room labels missing.',
        'comment' => 'Containers unlabelled.',
        'risk' => false,
        'severity' => 2,
    ]);

    Remediation::query()->create([
        'violation_id' => $resolved->id,
        'user_id' => $this->consultant->id,
        'comment' => 'Containers relabelled.',
        'completed' => true,
    ]);

    $this->get(route('dealer.audit.body-shop.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit.grade', 'B')
            ->where('previous_audit.violation_count', 2)
            ->where('previous_audit.open_remediation_count', 1)
            ->has('previous_audit.issues', 2)
            ->where('previous_audit.issues.0.statement', 'Spray booth filters overdue.')
            ->where('previous_audit.issues.0.remediation_resolved', false)
            ->where('previous_audit.issues.1.remediation_resolved', true));
});

it('omits the previous audit when no earlier completed audit exists', function (): void {
    $this->get(route('dealer.audit.body-shop.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit', null));
});

it('ignores incomplete audits when resolving the previous audit', function (): void {
    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
    ]);

    $this->get(route('dealer.audit.body-shop.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit', null));
});
