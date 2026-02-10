<?php

declare(strict_types=1);

use App\Notifications\VendorSignedNotification;
use App\Http\Livewire\Dealer\Vendor\NewForm;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function (): void {
    Storage::fake('do-manuals');
    Notification::fake();

    $this->store = Store::query()->create([
        'name' => 'Test Store',
        'address' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'postal_code' => '62701',
    ]);

    $this->vendor = Vendor::query()->create([
        'name' => 'Test Vendor',
        'contact_name' => 'John Doe',
        'contact_email' => 'john@vendor.com',
        'store_id' => $this->store->id,
    ]);

    $this->vendorForm = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
    ]);

    $this->qualifiedIndividual = User::query()->create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $this->qualifiedIndividual->assignRole('Qualified Individual');
});

describe('Document Upload', function (): void {
    it('allows submission with only a document uploaded', function (): void {
        $file = UploadedFile::fake()->create('risk-assessment.pdf', 1000, 'application/pdf');

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->set('document', $file)
            ->call('submit')
            ->assertRedirect(route('dealer.vendors.thankyou'));

        $this->vendorForm->refresh();

        expect($this->vendorForm->document_path)->not->toBeNull();
        expect($this->vendorForm->document_path)->toContain('vendor-documents/');
        expect($this->vendorForm->signature)->toBeNull();
    });

    it('validates document must be a PDF', function (): void {
        $file = UploadedFile::fake()->create('document.txt', 1000, 'text/plain');

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->set('document', $file)
            ->call('submit')
            ->assertHasErrors(['document']);
    });

    it('validates document size limit', function (): void {
        $file = UploadedFile::fake()->create('large.pdf', 15000, 'application/pdf');

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->set('document', $file)
            ->call('submit')
            ->assertHasErrors(['document']);
    });

    it('sends notification when document is uploaded', function (): void {
        $file = UploadedFile::fake()->create('risk-assessment.pdf', 1000, 'application/pdf');

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->set('document', $file)
            ->call('submit');

        Notification::assertSentTo(
            $this->qualifiedIndividual,
            VendorSignedNotification::class
        );
    });
});

describe('Form Submission Without Document', function (): void {
    it('requires all responses when no document is uploaded', function (): void {
        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->call('submit')
            ->assertHasErrors(['data.*.response', 'signature']);
    });

    it('allows submission with completed form and signature', function (): void {
        $responses = [];
        for ($i = 1; $i <= 22; $i++) {
            $responses["data.{$i}.response"] = 'yes';
        }

        $signature = 'data:image/png;base64,'.base64_encode('fake-signature-data');

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->set($responses)
            ->set('signature', $signature)
            ->call('submit')
            ->assertRedirect(route('dealer.vendors.thankyou'));

        $this->vendorForm->refresh();

        expect($this->vendorForm->signature)->not->toBeNull();
        expect($this->vendorForm->data)->not->toBeNull();
    });
});

describe('Component Rendering', function (): void {
    it('renders the form correctly', function (): void {
        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->assertStatus(200)
            ->assertSee('Upload Completed Risk Assessment Document');
    });

    it('redirects if form already has a signature', function (): void {
        $this->vendorForm->update(['signature' => 'existing-signature.png']);

        Livewire::test(NewForm::class, ['vid' => $this->vendorForm->id])
            ->assertRedirect(route('dealer.vendors.thankyou'));
    });
});
