<?php

declare(strict_types=1);

use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

it('renders the index page with audits scoped to the current store', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-01',
        'grade' => 'A',
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.osha.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Index')
            ->where('type', 'osha')
            ->where('label', 'OSHA')
            ->where('audits.data.0.id', $audit->id)
            ->where('audits.data.0.grade', 'A'));
});

it('returns an empty index when no audits exist', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.osha.index'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('tenant/audits/Index')
            ->where('audits.data', [])
            ->where('legacy_audits', []));
});
