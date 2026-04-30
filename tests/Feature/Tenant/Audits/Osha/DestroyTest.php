<?php

declare(strict_types=1);

use App\Models\AuditComment;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Str;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $this->store->id]);
    $this->actingAs($this->consultant);
});

it('soft-deletes the audit and cascades audit comments', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-15',
    ]);

    $comment = $audit->auditComments()->create([
        'user_id' => $this->consultant->id,
        'comment' => 'A comment.',
    ]);

    $this->delete(route('dealer.audit.osha.destroy', $audit->uuid))
        ->assertRedirect(route('dealer.audit.osha.index'));

    expect(OshaViolationAudit::query()->find($audit->id))->toBeNull()
        ->and(AuditComment::query()->find($comment->id))->toBeNull();
});
