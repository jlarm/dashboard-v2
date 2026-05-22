<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
use App\Models\Remediation;
use App\Models\ViolationStatement;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->actingAs($this->consultant);

    $this->audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-13',
    ]);
});

it('renders the edit page with violations and reference image data', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => 'https://cdn.example.com/reference.jpg',
    ]));

    $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Eye wash station obstructed.',
    ]);

    $this->get(route('dealer.audit.osha.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('audit.violations.0.reference_image_url', 'https://cdn.example.com/reference.jpg'));
});

it('persists violation comment, severity, risk and reference image flag on update', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'reference_image_url' => 'https://cdn.example.com/reference.jpg',
    ]));

    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => $statement->id,
        'statement' => $statement->statement,
        'comment' => 'Initial.',
        'risk' => false,
        'severity' => 3,
        'show_reference_image' => false,
    ]);

    $this->patch(route('dealer.audit.osha.update', $this->audit->uuid), [
        'date' => '2026-04-14',
        'violations' => [
            [
                'id' => $violation->id,
                'comment' => 'Updated comment.',
                'violation_date' => '2026-04-14',
                'risk' => 1,
                'severity' => 7,
                'show_reference_image' => 1,
            ],
        ],
    ])->assertRedirect();

    $fresh = Violation::query()->find($violation->id);

    expect($fresh->comment)->toBe('Updated comment.')
        ->and($fresh->risk)->toBeTrue()
        ->and($fresh->severity)->toBe(7)
        ->and($fresh->show_reference_image)->toBeTrue();

    expect(OshaViolationAudit::query()->find($this->audit->id)->date->format('Y-m-d'))->toBe('2026-04-14');
});

it('summarises the previous completed audit, unresolved issues first', function (): void {
    $previous = OshaViolationAudit::query()->create([
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
        'statement' => 'Eyewash station blocked.',
        'comment' => 'Pallet in front of station.',
        'risk' => true,
        'severity' => 8,
    ]);

    $resolved = $previous->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 2,
        'statement' => 'SDS binder missing.',
        'comment' => 'No binder on site.',
        'risk' => false,
        'severity' => 2,
    ]);

    Remediation::query()->create([
        'violation_id' => $resolved->id,
        'user_id' => $this->consultant->id,
        'comment' => 'Binder restocked.',
        'completed' => true,
    ]);

    $this->get(route('dealer.audit.osha.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit.grade', 'B')
            ->where('previous_audit.violation_count', 2)
            ->where('previous_audit.open_remediation_count', 1)
            ->has('previous_audit.issues', 2)
            ->where('previous_audit.issues.0.statement', 'Eyewash station blocked.')
            ->where('previous_audit.issues.0.remediation_resolved', false)
            ->where('previous_audit.issues.1.remediation_resolved', true));
});

it('omits the previous audit when no earlier completed audit exists', function (): void {
    $this->get(route('dealer.audit.osha.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit', null));
});

it('ignores incomplete audits when resolving the previous audit', function (): void {
    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
    ]);

    $this->get(route('dealer.audit.osha.edit', $this->audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Edit')
            ->where('previous_audit', null));
});

it('allows updates with an empty violation comment', function (): void {
    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Aisle blocked.',
        'comment' => 'Existing comment.',
    ]);

    $this->from(route('dealer.audit.osha.edit', $this->audit->uuid))
        ->patch(route('dealer.audit.osha.update', $this->audit->uuid), [
            'date' => '2026-04-14',
            'violations' => [
                [
                    'id' => $violation->id,
                    'comment' => '',
                    'risk' => 0,
                    'severity' => 3,
                    'show_reference_image' => 0,
                ],
            ],
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(Violation::query()->find($violation->id)->comment)->toBe('');
});
