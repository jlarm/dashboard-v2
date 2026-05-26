<?php

declare(strict_types=1);

use App\Jobs\UploadIndividualAuditToDigitalOceanJob;
use App\Models\Dealer\Audit\IndividualAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-audits');

    $store = Store::query()->firstOrFail();

    $this->audit = IndividualAudit::query()->create([
        'store_id' => $store->id,
        'pdf_path' => 'audit-'.uniqid().'.pdf',
    ]);
});

it('uploads the pdf to do-audits and deletes the local copy on success', function (): void {
    $localPath = '/individual-audits/'.$this->audit->pdf_path;
    Storage::put($localPath, 'pdf-bytes');

    new UploadIndividualAuditToDigitalOceanJob($this->audit)->handle();

    $expectedRemotePath = tenant('id').'/individual-audits/'.$this->audit->pdf_path;

    Storage::disk('do-audits')->assertExists($expectedRemotePath);
    expect(Storage::disk('do-audits')->get($expectedRemotePath))->toBe('pdf-bytes');
    Storage::assertMissing($localPath);
});

it('does nothing when the local pdf is missing', function (): void {
    new UploadIndividualAuditToDigitalOceanJob($this->audit)->handle();

    Storage::disk('do-audits')->assertMissing(tenant('id').'/individual-audits/'.$this->audit->pdf_path);
});
