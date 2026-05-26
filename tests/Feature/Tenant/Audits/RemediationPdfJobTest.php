<?php

declare(strict_types=1);

use App\Jobs\Audit\GenerateBodyShopRemediationPdfJob;
use App\Jobs\Audit\GenerateGlbaRemediationPdfJob;
use App\Jobs\Audit\GenerateOshaRemediationPdfJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelPdf\Facades\Pdf;

beforeEach(function (): void {
    Storage::fake('local');
    Storage::fake('armpaudits');
    Pdf::fake();

    Carbon::setTestNow('2026-06-15 12:00:00');
});

afterEach(function (): void {
    Carbon::setTestNow();
});

dataset('remediation_jobs', [
    'osha' => [
        OshaViolationAudit::class,
        GenerateOshaRemediationPdfJob::class,
        'osha',
        'osha-violation-audit-remediation.pdf',
    ],
    'glba' => [
        GlbaViolationAudit::class,
        GenerateGlbaRemediationPdfJob::class,
        'glba',
        'glba-violation-audit-remediation.pdf',
    ],
    'body_shop' => [
        BodyShopViolationAudit::class,
        GenerateBodyShopRemediationPdfJob::class,
        'body-shop',
        'body-shop-violation-audit-remediation.pdf',
    ],
]);

it('moves the remediation pdf to armpaudits, deletes the local copy, and updates the audit', function (
    string $auditClass,
    string $jobClass,
    string $auditTypeSlug,
    string $filenameSuffix,
): void {
    // Two stores so the filename builder picks the store branch (not the tenant fallback).
    Store::query()->create(['name' => 'Second Branch', 'slug' => 'second-'.uniqid()]);
    $store = Store::query()->where('slug', 'test-store')->firstOrFail();
    $store->update(['name' => 'Acme Motors']);

    /** @var App\Models\Dealer\Audit\Contracts\ViolationAudit&Illuminate\Database\Eloquent\Model $audit */
    $audit = $auditClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => now()->subDays(2),
        'grade' => 'A',
    ]);

    $expectedFilename = mb_strtolower(str_replace(' ', '-', (string) $store->name)).
        '-'.now()->format('Ymd').'-'.$filenameSuffix;

    // Pdf::fake() short-circuits save(); pre-stage the file the job will move.
    Storage::disk('local')->put('temp/'.$expectedFilename, 'fake-pdf-bytes');

    new $jobClass($audit)->handle();

    $expectedRemotePath = tenant('id').'/'.$auditTypeSlug.'/'.$expectedFilename;

    Storage::disk('armpaudits')->assertExists($expectedRemotePath);
    expect(Storage::disk('armpaudits')->get($expectedRemotePath))->toBe('fake-pdf-bytes');
    Storage::disk('local')->assertMissing('temp/'.$expectedFilename);

    expect($audit->fresh()->remediation_pdf_path)->toBe($expectedRemotePath);
})->with('remediation_jobs');

it('falls back to the tenant name in the filename when only one store exists', function (
    string $auditClass,
    string $jobClass,
    string $auditTypeSlug,
    string $filenameSuffix,
): void {
    // Exactly one store (the one TenantTestCase created).
    $store = Store::query()->firstOrFail();
    expect(Store::query()->count())->toBe(1);

    /** @var App\Models\Dealer\Audit\Contracts\ViolationAudit&Illuminate\Database\Eloquent\Model $audit */
    $audit = $auditClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => now()->subDays(2),
        'grade' => 'A',
    ]);

    $expectedFilename = mb_strtolower(str_replace(' ', '-', (string) tenant('name'))).
        '-'.now()->format('Ymd').'-'.$filenameSuffix;

    Storage::disk('local')->put('temp/'.$expectedFilename, 'fake-pdf-bytes');

    new $jobClass($audit)->handle();

    expect($audit->fresh()->remediation_pdf_path)
        ->toBe(tenant('id').'/'.$auditTypeSlug.'/'.$expectedFilename);
})->with('remediation_jobs');

it('does nothing when the staged pdf is missing (job logs the error and bails)', function (
    string $auditClass,
    string $jobClass,
): void {
    $store = Store::query()->firstOrFail();

    /** @var App\Models\Dealer\Audit\Contracts\ViolationAudit&Illuminate\Database\Eloquent\Model $audit */
    $audit = $auditClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $store->id,
        'date' => now()->subDays(2),
        'grade' => 'A',
    ]);

    // Intentionally do NOT pre-stage the file.
    new $jobClass($audit)->handle();

    expect($audit->fresh()->remediation_pdf_path)->toBeNull();
})->with('remediation_jobs');
