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

it('adds a violation from a statement', function (): void {
    $statement = tenancy()->central(fn () => ViolationStatement::factory()->create([
        'statement' => 'Fire extinguisher missing inspection tag.',
    ]));

    $this->post(route('dealer.audit.osha.violations.store', $this->audit->uuid), [
        'statement_id' => $statement->id,
    ])->assertRedirect();

    expect($this->audit->violations()->count())->toBe(1);
    $violation = $this->audit->violations()->first();
    expect($violation->statement_id)->toBe($statement->id)
        ->and($violation->statement)->toBe('Fire extinguisher missing inspection tag.');
});

it('deletes a violation', function (): void {
    $violation = $this->audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Sample violation.',
        'comment' => '.',
    ]);

    $this->delete(route('dealer.audit.osha.violations.destroy', [
        'audit' => $this->audit->uuid,
        'violation' => $violation->id,
    ]))->assertRedirect();

    expect(Violation::query()->find($violation->id))->toBeNull();
});
