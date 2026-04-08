<?php

declare(strict_types=1);

use App\Jobs\Audit\UploadOshaPdfJob;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('armpaudits');

    $this->store = Store::query()->firstOrFail();

    $this->audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-04-08',
        'grade' => 'A',
        'pdf_path' => 'audit-report.pdf',
    ]);
});

it('throws when the pdf does not exist in local storage', function (): void {
    expect(fn () => (new UploadOshaPdfJob($this->audit))->handle())
        ->toThrow(RuntimeException::class, 'OSHA PDF not found at path: /osha/audit-report.pdf');
});

it('streams the pdf to armpaudits, deletes the local file, and updates pdf_path', function (): void {
    Storage::put('/osha/audit-report.pdf', 'pdf-content');

    (new UploadOshaPdfJob($this->audit))->handle();

    $expectedPath = tenant('id').'/osha/audit-report.pdf';

    Storage::disk('armpaudits')->assertExists($expectedPath);
    Storage::assertMissing('/osha/audit-report.pdf');
    expect($this->audit->fresh()->pdf_path)->toBe($expectedPath);
});

