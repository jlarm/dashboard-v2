<?php

declare(strict_types=1);

use App\Jobs\Manuals\UploadCmsToDigitalOceanJob;
use App\Jobs\Manuals\UploadIspToDigitaloceanJob;
use App\Jobs\Manuals\UploadOshaToDigitalOceanJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
});

dataset('upload_manual_jobs', [
    'cms' => [
        CmsManual::class,
        UploadCmsToDigitalOceanJob::class,
        'cms',
        [
            'qi_name' => 'QI Name',
            'standard_dpp_rate' => 1.0,
            'adoption_approval_name_one' => 'Adopter One',
            'adoption_approval_signature_one' => '',
            'adoption_approval_name_two' => '',
            'adoption_approval_signature_two' => '',
            'adoption_approval_name_three' => '',
            'adoption_approval_signature_three' => '',
            'dealer_participation_program_name' => 'Dealer Name',
            'dealer_participation_program_signature' => '',
            'acknowledgement_name' => 'Ack Name',
            'acknowledgement_signature' => '',
        ],
    ],
    'isp' => [
        Isp::class,
        UploadIspToDigitaloceanJob::class,
        'isp',
        [
            'qualified_individual_name' => 'QI',
            'qualified_individual_phone' => '555-555-5555',
        ],
    ],
    'osha' => [
        Osha::class,
        UploadOshaToDigitalOceanJob::class,
        'osha',
        [
            'qualified_individual_name' => 'QI',
            'qualified_individual_phone' => '555-555-5555',
        ],
    ],
    'red-flag' => [
        RedFlag::class,
        UploadRedFlagToDigitalOceanJob::class,
        'red-flags',
        [
            'qualified_individual_name' => 'QI',
            'qualified_individual_phone' => '555-555-5555',
        ],
    ],
]);

it('moves the manual pdf to do-manuals and deletes the local copy on success', function (
    string $modelClass,
    string $jobClass,
    string $pathPrefix,
    array $extra,
): void {
    $store = Store::query()->firstOrFail();

    $pdfName = 'manual-'.uniqid().'.pdf';
    $manual = $modelClass::query()->create([
        'store_id' => $store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => $pdfName,
        ...$extra,
    ]);

    Storage::put('/'.$pdfName, 'pdf-bytes');

    new $jobClass($manual)->handle();

    $expectedRemote = tenant('id').'/'.$pathPrefix.'/'.$pdfName;
    Storage::disk('do-manuals')->assertExists($expectedRemote);
    expect(Storage::disk('do-manuals')->get($expectedRemote))->toBe('pdf-bytes');
    Storage::assertMissing('/'.$pdfName);
})->with('upload_manual_jobs');

it('does nothing when the local pdf is missing', function (
    string $modelClass,
    string $jobClass,
    string $pathPrefix,
    array $extra,
): void {
    $store = Store::query()->firstOrFail();

    $pdfName = 'missing-'.uniqid().'.pdf';
    $manual = $modelClass::query()->create([
        'store_id' => $store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => $pdfName,
        ...$extra,
    ]);

    new $jobClass($manual)->handle();

    Storage::disk('do-manuals')->assertMissing(tenant('id').'/'.$pathPrefix.'/'.$pdfName);
})->with('upload_manual_jobs');
