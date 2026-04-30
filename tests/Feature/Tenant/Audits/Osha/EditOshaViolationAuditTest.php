<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Dealer\Violation;
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

it('rejects updates that violate the comment requirement', function (): void {
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
                ['id' => $violation->id, 'comment' => ''],
            ],
        ])
        ->assertSessionHasErrors('violations.0.comment');
});
