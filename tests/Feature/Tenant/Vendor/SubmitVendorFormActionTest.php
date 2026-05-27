<?php

declare(strict_types=1);

use App\Domain\Tenant\Vendor\Actions\SubmitVendorForm;
use App\Domain\Tenant\Vendor\Data\SubmitVendorFormData;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use App\Notifications\VendorSignedNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    $store = Store::query()->firstOrFail();

    $this->vendor = Vendor::query()->create([
        'name' => 'Acme Supplies',
        'contact_name' => 'Sam Vendor',
        'contact_email' => 'sam@vendor.test',
        'store_id' => $store->id,
    ]);

    $this->vendorForm = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
    ]);
});

it('stores the signature image and persists the response data', function (): void {
    Notification::fake();
    Storage::fake();

    $signature = 'data:image/png;base64,'.base64_encode('signature-bytes');
    // Questions are 1-indexed; supply 22 responses keyed 1..22 to match.
    $responses = [];
    for ($i = 1; $i <= 22; $i++) {
        $responses[$i] = ['response' => $i === 2 ? 'no' : 'yes', 'comment' => $i === 2 ? 'because of policy' : null];
    }

    new SubmitVendorForm()->handle($this->vendorForm, new SubmitVendorFormData(
        document: null,
        signature: $signature,
        responses: $responses,
    ));

    $this->vendorForm->refresh();
    expect($this->vendorForm->signature)->not->toBeNull();
    expect($this->vendorForm->document_path)->toBeNull();
    expect($this->vendorForm->data)->toHaveCount(22);
    expect($this->vendorForm->data[1]['response'])->toBe('yes');
    expect($this->vendorForm->data[2]['response'])->toBe('no');
    expect($this->vendorForm->data[2]['comment'])->toBe('because of policy');

    Storage::disk('local')->assertExists('signatures/'.$this->vendorForm->signature);
});

it('stores an uploaded document on the do-manuals disk and leaves the signature unset', function (): void {
    Notification::fake();
    Storage::fake('do-manuals');

    $document = UploadedFile::fake()->create('vendor-doc.pdf', 100, 'application/pdf');

    new SubmitVendorForm()->handle($this->vendorForm, new SubmitVendorFormData(
        document: $document,
        signature: null,
        responses: null,
    ));

    $this->vendorForm->refresh();
    expect($this->vendorForm->document_path)->not->toBeNull();
    expect($this->vendorForm->signature)->toBeNull();
    expect((string) $this->vendorForm->document_path)->toContain(tenant('id').'/vendor-documents');

    Storage::disk('do-manuals')->assertExists($this->vendorForm->document_path);
});

it('notifies every Qualified Individual when the form is signed', function (): void {
    Notification::fake();
    Storage::fake();

    $qi = User::query()->create([
        'name' => 'Qi Person',
        'email' => 'qi-'.uniqid().'@test-tenant.localhost',
        'password' => bcrypt('x'),
    ]);
    $qi->assignRole('Qualified Individual');

    $signature = 'data:image/png;base64,'.base64_encode('sig');

    new SubmitVendorForm()->handle($this->vendorForm, new SubmitVendorFormData(
        document: null,
        signature: $signature,
        responses: array_fill(1, 22, ['response' => 'yes', 'comment' => null]),
    ));

    Notification::assertSentTo($qi, VendorSignedNotification::class);
});

it('does not blow up when there are no Qualified Individuals to notify', function (): void {
    Notification::fake();
    Storage::fake();

    $signature = 'data:image/png;base64,'.base64_encode('sig');

    new SubmitVendorForm()->handle($this->vendorForm, new SubmitVendorFormData(
        document: null,
        signature: $signature,
        responses: array_fill(0, 22, ['response' => 'na', 'comment' => null]),
    ));

    Notification::assertNothingSent();
});
