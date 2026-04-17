<?php

declare(strict_types=1);

use App\Jobs\Audit\UploadGlbaPdfJob;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('armpaudits');

    $this->store = Store::query()->firstOrFail();

    $this->audit = GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-08',
        'grade' => 'A',
        'pdf_path' => 'audit-report.pdf',
    ]);
});

it('throws when the pdf does not exist in local storage', function (): void {
    expect(fn () => new UploadGlbaPdfJob($this->audit)->handle())
        ->toThrow(RuntimeException::class, 'GLBA PDF not found at path: /glba/audit-report.pdf');
});

it('streams the pdf to armpaudits, deletes the local file, and updates pdf_path', function (): void {
    Storage::put('/glba/audit-report.pdf', 'pdf-content');

    new UploadGlbaPdfJob($this->audit)->handle();

    $expectedPath = tenant('id').'/glba/audit-report.pdf';

    Storage::disk('armpaudits')->assertExists($expectedPath);
    Storage::assertMissing('/glba/audit-report.pdf');
    expect($this->audit->fresh()->pdf_path)->toBe($expectedPath);
});
