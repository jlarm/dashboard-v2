<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->actingAs($this->consultant);
});

it('renders the show page with violations and rating', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-15',
        'grade' => 'B',
    ]);

    $audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Sample violation.',
        'comment' => 'Detail.',
    ]);

    $this->get(route('dealer.audit.osha.show', $audit->uuid))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Show')
            ->where('audit.uuid', $audit->uuid)
            ->where('audit.violation_count', 1)
            ->where('audit.rating', 75));
});

it('returns 404 for an unknown audit uuid', function (): void {
    $this->get(route('dealer.audit.osha.show', 'unknown-uuid'))
        ->assertNotFound();
});
