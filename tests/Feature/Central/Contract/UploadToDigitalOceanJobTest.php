<?php

declare(strict_types=1);

use App\Jobs\Contracts\UploadToDigitalOceanJob;
use App\Models\Contract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

beforeEach(function (): void {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('contracts')->truncate();
    DB::table('users')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    Storage::fake();
    Storage::fake('armpcon');
});

it('moves the PDF to the armpcon disk, deletes the local copy, and updates the contract pdf_path', function (): void {
    $contract = Contract::factory()->create([
        'uuid' => (string) Str::uuid(),
        'pdf_path' => 'invoice-'.uniqid().'.pdf',
    ]);
    $localPath = 'contracts/'.$contract->pdf_path;
    $expectedRemotePath = $contract->uuid.'/'.$contract->pdf_path;
    Storage::put($localPath, 'pdf-bytes');

    (new UploadToDigitalOceanJob($contract))->handle();

    Storage::assertMissing($localPath);
    Storage::disk('armpcon')->assertExists($expectedRemotePath);
    expect(Storage::disk('armpcon')->get($expectedRemotePath))->toBe('pdf-bytes');

    expect($contract->fresh()->pdf_path)->toBe($expectedRemotePath);
});

it('does nothing when the local PDF is missing', function (): void {
    $originalPath = 'missing-'.uniqid().'.pdf';
    $contract = Contract::factory()->create([
        'uuid' => (string) Str::uuid(),
        'pdf_path' => $originalPath,
    ]);

    (new UploadToDigitalOceanJob($contract))->handle();

    Storage::disk('armpcon')->assertMissing($contract->uuid.'/'.$originalPath);
    expect($contract->fresh()->pdf_path)->toBe($originalPath);
});
