<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

beforeEach(function (): void {
    Pdf::fake();
});

it('streams a violation-audit PDF for the latest completed OSHA audit', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subDays(2),
        'grade' => 'A',
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'osha']))
        ->assertOk();

    Pdf::assertRespondedWithPdf(
        fn ($pdf): bool => str_contains($pdf->viewName, 'osha'),
    );
});

it('picks the most recent completed audit (highest date, then highest id) when multiple exist', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subMonths(2),
        'grade' => 'B',
    ]);
    $newest = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subDay(),
        'grade' => 'A',
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'osha']))
        ->assertOk();

    Pdf::assertRespondedWithPdf(
        fn ($pdf): bool => $pdf->viewData['audit']->getKey() === $newest->getKey(),
    );
});

it('skips audits with no grade or grade "N/A"', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subDays(2),
        'grade' => 'N/A',
    ]);
    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => CarbonImmutable::now()->subDays(2),
        'grade' => null,
    ]);

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'osha']))
        ->assertNotFound();
});

it('streams the deal-jacket report file for the latest completed group', function (): void {
    Bus::fake([GenerateDealJacketReportJob::class]);
    Storage::fake();

    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $group = DealJacketGroup::query()->create([
        'uuid' => (string) Str::uuid(),
        'store_id' => $store->id,
        'completed' => true,
    ]);

    $storeName = str_replace(' ', '-', (string) $group->store->name);
    $fileName = ($group->created_at?->format('Ymd-His') ?? '')."-{$storeName}-deal-jacket-report.pdf";
    $filePath = "deal-jacket-reports/{$fileName}";
    Storage::put($filePath, 'fake-pdf-bytes');

    $this->actingAs($this->consultant)
        ->get(route('dealer.dashboard.audit-type-report', ['type' => 'deal_jacket']))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf')
        ->assertDownload($fileName);

    Bus::assertDispatchedSync(GenerateDealJacketReportJob::class);
});

it('rejects requests for types outside the allow-list via the route constraint', function (): void {
    $store = Store::query()->firstOrFail();
    $this->consultant->update(['current_store_id' => $store->id]);

    $this->actingAs($this->consultant)
        ->get('/dashboard/audit-report/bogus-type')
        ->assertNotFound();
});
