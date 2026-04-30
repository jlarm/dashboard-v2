<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

it('creates a fresh OSHA violation audit and redirects to its edit page', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.osha.create', $this->store->id))
        ->assertRedirect();

    $audit = OshaViolationAudit::query()->where('store_id', $this->store->id)->latest()->first();

    expect($audit)->not->toBeNull()
        ->and($audit->user_id)->toBe($this->consultant->id);
});
