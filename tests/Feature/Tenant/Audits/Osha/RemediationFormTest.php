<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Audit\Osha\RemediationForm;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use App\Models\Remediation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->actingAs($this->consultant);
});

it('persists a new remediation photo upload', function (): void {
    Storage::fake('armpaudits');

    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
        'grade' => 'B',
    ]);

    $violation = $audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Eye wash station obstructed.',
        'comment' => 'Box stored in front of the station.',
        'violation_date' => '2026-03-09',
        'risk' => true,
    ]);

    Livewire::test(RemediationForm::class, ['oshaViolationAudit' => $audit])
        ->set("violationRemediations.{$violation->id}.comment", 'Obstruction removed and area marked.')
        ->set("violationRemediations.{$violation->id}.photo", UploadedFile::fake()->image('remediation.jpg'))
        ->call('editRemediations')
        ->assertHasNoErrors();

    $remediation = Remediation::query()->where('violation_id', $violation->id)->first();

    expect($remediation)->not->toBeNull();
    expect($remediation->comment)->toBe('Obstruction removed and area marked.');
    expect($remediation->user_id)->toBe($this->consultant->id);
    expect($remediation->getMedia('remediations'))->toHaveCount(1);
});

it('returns null when temporary upload preview generation fails', function (): void {
    $audit = OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-03-10',
        'grade' => 'B',
    ]);

    $violation = $audit->violations()->create([
        'uuid' => (string) Str::uuid(),
        'statement_id' => 1,
        'statement' => 'Fire extinguisher blocked.',
        'comment' => 'Cabinet moved.',
        'violation_date' => '2026-03-09',
        'risk' => true,
    ]);

    $component = Livewire::test(RemediationForm::class, ['oshaViolationAudit' => $audit]);

    $previewUrl = $component->instance()->temporaryPhotoPreviewUrl(new class
    {
        public function temporaryUrl(): string
        {
            throw new RuntimeException('This driver does not support creating temporary URLs.');
        }
    });

    expect($previewUrl)->toBeNull();
});
