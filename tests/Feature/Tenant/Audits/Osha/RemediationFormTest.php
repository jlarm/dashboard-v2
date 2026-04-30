<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Remediation;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->actingAs($this->consultant);
});

it('persists a remediation comment and completion flag via the controller', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
        'grade' => 'B',
    ]);

    $violation = $audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Eye wash station obstructed.',
        'comment' => 'Box stored in front of the station.',
        'violation_date' => '2026-03-09',
        'risk' => true,
    ]);

    $this->patch(route('dealer.audit.osha.remediation.update', $audit->uuid), [
        'remediations' => [
            $violation->id => [
                'comment' => 'Obstruction removed and area marked.',
                'completed' => 1,
            ],
        ],
    ])->assertRedirect();

    $remediation = Remediation::query()->where('violation_id', $violation->id)->first();

    expect($remediation)->not->toBeNull()
        ->and($remediation->comment)->toBe('Obstruction removed and area marked.')
        ->and($remediation->completed)->toBeTrue()
        ->and($remediation->user_id)->toBe($this->consultant->id);
});

it('removes a remediation entirely when comment, completion, and photo are all empty', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
    ]);

    $violation = $audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Aisle blocked.',
        'comment' => 'Pallet in walkway.',
        'risk' => false,
    ]);

    $remediation = Remediation::query()->create([
        'violation_id' => $violation->id,
        'user_id' => $this->consultant->id,
        'comment' => 'Cleared.',
        'completed' => true,
    ]);

    $this->patch(route('dealer.audit.osha.remediation.update', $audit->uuid), [
        'remediations' => [
            $violation->id => [
                'comment' => '',
                'completed' => 0,
            ],
        ],
    ])->assertRedirect();

    expect(Remediation::query()->find($remediation->id))->toBeNull();
});
