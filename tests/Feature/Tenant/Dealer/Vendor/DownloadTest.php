<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Vendor\Download;
use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Storage::fake('do-manuals');

    $this->user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->store = Store::create([
        'name' => 'Test Store',
        'address' => '123 Main St',
        'city' => 'Springfield',
        'state' => 'IL',
        'postal_code' => '62701',
    ]);

    $this->vendor = Vendor::create([
        'name' => 'Test Vendor',
        'contact_name' => 'John Doe',
        'contact_email' => 'john@vendor.com',
        'store_id' => $this->store->id,
    ]);

    $this->vendorForm = VendorForm::create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
    ]);
});

describe('Download Uploaded Document', function () {
    it('downloads the uploaded document when document_path exists', function () {
        $documentPath = 'tenant-uuid/vendor-documents/test-document.pdf';
        Storage::disk('do-manuals')->put($documentPath, 'PDF content here');

        $this->vendorForm->update(['document_path' => $documentPath]);

        $this->actingAs($this->user);

        $response = Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->call('download');

        $payload = $response->payload;
        expect($payload['effects']['download'])->not->toBeNull();
        expect($payload['effects']['download']['name'])->toBe('TestVendor.pdf');
    });

    it('logs error when document file does not exist in storage', function () {
        Log::shouldReceive('error')
            ->once()
            ->withArgs(fn ($message) => str_contains($message, 'Vendor form document not found'));

        $this->vendorForm->update(['document_path' => 'non-existent/path.pdf']);

        $this->actingAs($this->user);

        Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->call('download');
    });
});

describe('Download Generated PDF', function () {
    it('generates PDF when no document_path exists and signature is present', function () {
        $this->vendorForm->update([
            'signature' => 'signature.png',
            'document_path' => null,
        ]);

        $this->actingAs($this->user);

        // Mock Browsershot to avoid requiring Chrome
        $this->mock(\Spatie\Browsershot\Browsershot::class, function ($mock) {
            $mock->shouldReceive('html')->andReturnSelf();
            $mock->shouldReceive('noSandbox')->andReturnSelf();
            $mock->shouldReceive('showBackground')->andReturnSelf();
            $mock->shouldReceive('margins')->andReturnSelf();
            $mock->shouldReceive('format')->andReturnSelf();
            $mock->shouldReceive('pdf')->andReturn('fake pdf content');
        });

        $response = Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->call('download');

        expect($response->effects['download'])->not->toBeNull();
    })->skip('Browsershot mocking requires additional setup');
});

describe('Component Rendering', function () {
    it('renders the download component', function () {
        $this->actingAs($this->user);

        Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->assertStatus(200)
            ->assertSee('Download Completed Form');
    });

    it('shows disabled button when no signature and no document_path', function () {
        $this->vendorForm->update([
            'signature' => null,
            'document_path' => null,
        ]);

        $this->actingAs($this->user);

        Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->assertStatus(200)
            ->assertSeeHtml('disabled');
    });

    it('shows enabled button when signature exists', function () {
        $this->vendorForm->update(['signature' => 'signature.png']);

        $this->actingAs($this->user);

        Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->assertStatus(200)
            ->assertDontSeeHtml('disabled wire:click');
    });

    it('shows enabled button when document_path exists', function () {
        $this->vendorForm->update(['document_path' => 'path/to/document.pdf']);

        $this->actingAs($this->user);

        Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->assertStatus(200)
            ->assertDontSeeHtml('disabled wire:click');
    });
});

describe('PDF Filename', function () {
    it('uses vendor name for the PDF filename', function () {
        $documentPath = 'tenant-uuid/vendor-documents/uploaded.pdf';
        Storage::disk('do-manuals')->put($documentPath, 'PDF content');

        $this->vendor->update(['name' => 'Acme Corporation']);
        $this->vendorForm->update(['document_path' => $documentPath]);

        $this->actingAs($this->user);

        $response = Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->call('download');

        $payload = $response->payload;
        expect($payload['effects']['download']['name'])->toBe('AcmeCorporation.pdf');
    });

    it('removes spaces from vendor name in filename', function () {
        $documentPath = 'tenant-uuid/vendor-documents/uploaded.pdf';
        Storage::disk('do-manuals')->put($documentPath, 'PDF content');

        $this->vendor->update(['name' => 'My Test Vendor Company']);
        $this->vendorForm->update(['document_path' => $documentPath]);

        $this->actingAs($this->user);

        $response = Livewire::test(Download::class, ['vendorForm' => $this->vendorForm])
            ->call('download');

        $payload = $response->payload;
        expect($payload['effects']['download']['name'])->toBe('MyTestVendorCompany.pdf');
    });
});
