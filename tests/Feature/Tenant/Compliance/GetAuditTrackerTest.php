<?php

declare(strict_types=1);

use App\Domain\Tenant\Compliance\Queries\GetAuditTracker;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;

it('returns four rows with overdue status when no stores are scoped', function (): void {
    $rows = (new GetAuditTracker())->handleForStores([]);

    expect($rows)->toHaveCount(4);
    expect(collect($rows)->pluck('type_key')->all())
        ->toBe(['osha', 'body_shop', 'glba', 'deal_jacket']);

    foreach ($rows as $row) {
        expect($row->grade)->toBeNull();
        expect($row->status)->toBe('overdue');
        expect($row->last_audit_date)->toBeNull();
        expect($row->has_report)->toBeFalse();
    }
});

it('flags has_report when the latest violation audit has a pdf_path', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'A',
        'pdf_path' => 'audits/osha/store-1.pdf',
    ]);

    $row = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'osha');

    expect($row->has_report)->toBeTrue();
});

it('does not flag has_report when the latest violation audit lacks a pdf_path', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'A',
        'pdf_path' => null,
    ]);

    $row = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'osha');

    expect($row->has_report)->toBeFalse();
});

it('returns the latest audit per type with grade, formatted date, and passing status', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'A',
    ]);

    $rows = (new GetAuditTracker())->handleForStores([$store->id], $now);

    $osha = collect($rows)->firstWhere('type_key', 'osha');
    expect($osha->grade)->toBe('A');
    expect($osha->status)->toBe('passing');
    expect($osha->last_audit_date)->toBe($now->subMonths(2)->format('M j, Y'));
});

it('computes a delta_label vs the prior completed audit', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(6),
        'grade' => 'C',
    ]);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(1),
        'grade' => 'A',
    ]);

    $osha = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'osha');

    expect($osha->grade)->toBe('A');
    expect($osha->delta_label)->toBe('+2 vs prior');
});

it('reports No change when grades match', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    foreach ([4, 1] as $monthsAgo) {
        BodyShopViolationAudit::query()->create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $this->consultant->id,
            'store_id' => $store->id,
            'date' => $now->subMonths($monthsAgo),
            'grade' => 'B',
        ]);
    }

    $row = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'body_shop');

    expect($row->delta_label)->toBe('No change');
});

it('marks an audit older than 12 months as overdue regardless of grade', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(18),
        'grade' => 'A',
    ]);

    $glba = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'glba');

    expect($glba->status)->toBe('overdue');
});

it('grades the deal_jacket row from the latest IndividualAudit rating', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    IndividualAudit::query()->create([
        'store_id' => $store->id,
        'audit_date' => $now->subMonths(2),
        'rating' => 95.0,
    ]);

    $row = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'deal_jacket');

    expect($row->grade)->toBe('A');
    expect($row->status)->toBe('passing');
    expect($row->last_audit_date)->toBe($now->subMonths(2)->format('M j, Y'));
});

it('computes a deal_jacket delta_label from successive ratings', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    IndividualAudit::query()->create([
        'store_id' => $store->id,
        'audit_date' => $now->subMonths(6),
        'rating' => 75.0, // Grade C
    ]);

    IndividualAudit::query()->create([
        'store_id' => $store->id,
        'audit_date' => $now->subMonths(1),
        'rating' => 92.0, // Grade A
    ]);

    $row = collect((new GetAuditTracker())->handleForStores([$store->id], $now))
        ->firstWhere('type_key', 'deal_jacket');

    expect($row->grade)->toBe('A');
    expect($row->delta_label)->toBe('+2 vs prior');
});

it('maps grade C to action_required and grade D to overdue', function (): void {
    $store = Store::query()->firstOrFail();
    $now = CarbonImmutable::create(2026, 5, 15);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'C',
    ]);

    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => $now->subMonths(2),
        'grade' => 'D',
    ]);

    $rows = collect((new GetAuditTracker())->handleForStores([$store->id], $now));

    expect($rows->firstWhere('type_key', 'osha')->status)->toBe('action_required');
    expect($rows->firstWhere('type_key', 'body_shop')->status)->toBe('overdue');
});
