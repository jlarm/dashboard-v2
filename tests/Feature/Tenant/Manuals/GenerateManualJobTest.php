<?php

declare(strict_types=1);

use App\Jobs\Manuals\GenerateCmsManualJob;
use App\Jobs\Manuals\GenerateIspManualJob;
use App\Jobs\Manuals\GenerateOshaManualJob;
use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Spatie\LaravelPdf\Facades\Pdf;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    Pdf::fake();
});

dataset('manual_generate_jobs', [
    'cms' => [
        CmsManual::class,
        GenerateCmsManualJob::class,
        'dealer.manual.pdf.cms',
        'cms',
        'cms-manual-',
        [
            'qi_name' => 'QI Name',
            'standard_dpp_rate' => 1.0,
            'adoption_approval_name_one' => 'Adopter',
            'adoption_approval_signature_one' => '',
            'adoption_approval_name_two' => '',
            'adoption_approval_signature_two' => '',
            'adoption_approval_name_three' => '',
            'adoption_approval_signature_three' => '',
            'dealer_participation_program_name' => 'Dealer',
            'dealer_participation_program_signature' => '',
            'acknowledgement_name' => 'Ack',
            'acknowledgement_signature' => '',
        ],
    ],
    'isp' => [
        Isp::class,
        GenerateIspManualJob::class,
        'dealer.manual.pdf.isp',
        'isp',
        'isp-manual-',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'osha' => [
        Osha::class,
        GenerateOshaManualJob::class,
        'dealer.manual.pdf.osha',
        'osha',
        'osha-manual-',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'red-flag' => [
        RedFlag::class,
        GenerateRedFlagManualJob::class,
        'dealer.manual.pdf.red-flag',
        'redFlag',
        'red-flags-manual-',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
]);

it('renders the right view, saves to storage/app, and updates the manual pdf_path', function (
    string $modelClass,
    string $jobClass,
    string $viewName,
    string $viewVar,
    string $filenamePrefix,
    array $attrs,
): void {
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        ...$attrs,
    ]);

    new $jobClass($manual)->handle();

    Pdf::assertSaved(fn ($pdf, string $path): bool => $pdf->viewName === $viewName
            && ($pdf->viewData[$viewVar] ?? null)?->getKey() === $manual->getKey()
            && str_starts_with(basename($path), $filenamePrefix)
            && str_ends_with($path, '.pdf')
            && str_starts_with($path, storage_path('app/')));

    expect($manual->fresh()->pdf_path)
        ->toStartWith($filenamePrefix)
        ->toEndWith('.pdf');
})->with('manual_generate_jobs');
