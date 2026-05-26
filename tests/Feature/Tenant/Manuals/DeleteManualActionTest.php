<?php

declare(strict_types=1);

use App\Domain\Tenant\Manuals\Cms\Actions\DeleteCmsManual;
use App\Domain\Tenant\Manuals\Isp\Actions\DeleteIspManual;
use App\Domain\Tenant\Manuals\Osha\Actions\DeleteOshaManual;
use App\Domain\Tenant\Manuals\RedFlag\Actions\DeleteRedFlagManual;
use App\Models\CmsManual;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
    $this->store = Store::query()->firstOrFail();
});

dataset('delete_manual_actions', [
    'cms' => [
        CmsManual::class,
        DeleteCmsManual::class,
        'cms',
        [
            'qi_name' => 'QI',
            'standard_dpp_rate' => 1.0,
            'adoption_approval_name_one' => 'A',
            'adoption_approval_signature_one' => '',
            'adoption_approval_name_two' => '',
            'adoption_approval_signature_two' => '',
            'adoption_approval_name_three' => '',
            'adoption_approval_signature_three' => '',
            'dealer_participation_program_name' => 'D',
            'dealer_participation_program_signature' => '',
            'acknowledgement_name' => 'Ack',
            'acknowledgement_signature' => '',
        ],
    ],
    'isp' => [
        Isp::class,
        DeleteIspManual::class,
        'isp',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'osha' => [
        Osha::class,
        DeleteOshaManual::class,
        'osha',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
    'red-flag' => [
        RedFlag::class,
        DeleteRedFlagManual::class,
        'red-flags',
        ['qualified_individual_name' => 'QI', 'qualified_individual_phone' => '555'],
    ],
]);

it('deletes both the uploaded pdf on do-manuals and the local staging copy', function (
    string $modelClass,
    string $actionClass,
    string $diskPrefix,
    array $attrs,
): void {
    $pdfName = 'manual-'.uniqid().'.pdf';
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => $pdfName,
        ...$attrs,
    ]);

    // Both copies present — simulates the mid-flight case (local still there
    // because the Upload job hasn't run yet) AND the post-upload case where
    // only the remote exists. We assert both code paths clean up.
    Storage::put($pdfName, 'staged-bytes');
    Storage::disk('do-manuals')->put(tenant('id').'/'.$diskPrefix.'/'.$pdfName, 'remote-bytes');

    resolve($actionClass)->handle($manual);

    Storage::assertMissing($pdfName);
    Storage::disk('do-manuals')->assertMissing(tenant('id').'/'.$diskPrefix.'/'.$pdfName);
    expect($modelClass::query()->find($manual->getKey()))->toBeNull();
})->with('delete_manual_actions');

it('still deletes the local staging copy when the remote upload has not happened yet', function (
    string $modelClass,
    string $actionClass,
    string $diskPrefix,
    array $attrs,
): void {
    $pdfName = 'mid-flight-'.uniqid().'.pdf';
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => $pdfName,
        ...$attrs,
    ]);

    // Only local staging exists — Upload job hasn't moved it to do-manuals yet.
    Storage::put($pdfName, 'staged-bytes');

    resolve($actionClass)->handle($manual);

    Storage::assertMissing($pdfName);
    expect($modelClass::query()->find($manual->getKey()))->toBeNull();
})->with('delete_manual_actions');

it('skips file deletion when pdf_path is empty', function (
    string $modelClass,
    string $actionClass,
    string $diskPrefix,
    array $attrs,
): void {
    $manual = $modelClass::query()->create([
        'store_id' => $this->store->id,
        'user_id' => $this->consultant->id,
        'pdf_path' => null,
        ...$attrs,
    ]);

    // Drop a stranger file at the eventual local path to prove we don't
    // mass-delete just because pdf_path is empty.
    Storage::put('bystander.pdf', 'leave-me-alone');

    resolve($actionClass)->handle($manual);

    Storage::assertExists('bystander.pdf');
    expect($modelClass::query()->find($manual->getKey()))->toBeNull();
})->with('delete_manual_actions');
