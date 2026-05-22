<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);

    $this->audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-01',
        'completed_date' => '2026-04-02',
        'grade' => 'C',
    ]);
});

it('updates the grade of a completed audit', function (): void {
    $this->actingAs($this->consultant)
        ->patch(route('dealer.audit.osha.grade', $this->audit->uuid), ['grade' => 'A'])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect($this->audit->fresh()->grade)->toBe('A');
});

it('records who changed the grade and when', function (): void {
    $this->actingAs($this->consultant)
        ->patch(route('dealer.audit.osha.grade', $this->audit->uuid), ['grade' => 'B']);

    $audit = $this->audit->fresh();

    expect($audit->grade_updated_by)->toBe($this->consultant->id)
        ->and($audit->grade_updated_at)->not->toBeNull();
});

it('rejects grading an audit that is not yet completed', function (): void {
    $incomplete = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-05',
    ]);

    $this->actingAs($this->consultant)
        ->patch(route('dealer.audit.osha.grade', $incomplete->uuid), ['grade' => 'A'])
        ->assertStatus(422);

    expect($incomplete->fresh()->grade)->toBeNull();
});

it('rejects an invalid grade value', function (): void {
    $this->actingAs($this->consultant)
        ->patch(route('dealer.audit.osha.grade', $this->audit->uuid), ['grade' => 'Z'])
        ->assertSessionHasErrors('grade');

    expect($this->audit->fresh()->grade)->toBe('C');
});

it('forbids non-privileged roles from updating the grade', function (): void {
    $this->actingAs($this->manager)
        ->patch(route('dealer.audit.osha.grade', $this->audit->uuid), ['grade' => 'A'])
        ->assertForbidden();

    expect($this->audit->fresh()->grade)->toBe('C');
});
