<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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

describe('GET form (public form view)', function (): void {
    it('renders the public PublicForm Inertia page for an unsigned vendor form', function (): void {
        $url = URL::signedRoute('dealer.vendor.form', ['vid' => $this->vendorForm->id]);

        $this->get($url)
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/vendor/PublicForm')
                ->where('vendorForm.id', $this->vendorForm->id)
                ->where('storeName', 'Test Store')
                ->has('questions')
            );
    });

    it('redirects to the thank-you screen when the form is already signed', function (): void {
        $this->vendorForm->update(['signature' => 'already-signed.png']);

        $url = URL::signedRoute('dealer.vendor.form', ['vid' => $this->vendorForm->id]);

        $this->get($url)->assertRedirect(route('dealer.vendors.thankyou'));
    });

    it('redirects to the thank-you screen when the form already has an uploaded document', function (): void {
        $this->vendorForm->update(['document_path' => 'docs/vendor.pdf']);

        $url = URL::signedRoute('dealer.vendor.form', ['vid' => $this->vendorForm->id]);

        $this->get($url)->assertRedirect(route('dealer.vendors.thankyou'));
    });

    it('rejects unsigned access to the public form endpoint', function (): void {
        $this->get(route('dealer.vendor.form', ['vid' => $this->vendorForm->id]))
            ->assertForbidden();
    });
});

describe('POST submit (public form submission)', function (): void {
    it('accepts a signature submission and stores the response data', function (): void {
        Notification::fake();
        Storage::fake('local');

        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');
        $responses = collect(range(0, 21))->map(fn (): array => ['response' => 'yes', 'comment' => null])->all();

        $url = URL::signedRoute('dealer.vendor.submit', ['vid' => $this->vendorForm->id]);

        $this->withoutMiddleware([ValidateCsrfToken::class])
            ->post($url, [
                'signature' => $signature,
                'responses' => $responses,
            ])
            ->assertRedirect(route('dealer.vendors.thankyou'));

        $this->vendorForm->refresh();
        expect($this->vendorForm->signature)->not->toBeNull();
        expect($this->vendorForm->data)->toHaveCount(22);
    });

    it('redirects straight to the thank-you screen when the form is already signed', function (): void {
        Notification::fake();
        $this->vendorForm->update(['signature' => 'prev.png']);

        $signature = 'data:image/png;base64,'.base64_encode('sig');
        $responses = [];
        for ($i = 1; $i <= 22; $i++) {
            $responses[$i] = ['response' => 'yes', 'comment' => null];
        }

        $url = URL::signedRoute('dealer.vendor.submit', ['vid' => $this->vendorForm->id]);

        $this->withoutMiddleware([ValidateCsrfToken::class])
            ->post($url, ['signature' => $signature, 'responses' => $responses])
            ->assertRedirect(route('dealer.vendors.thankyou'));

        Notification::assertNothingSent();
    });

    it('returns a validation error when the signature and responses payload is missing', function (): void {
        $url = URL::signedRoute('dealer.vendor.submit', ['vid' => $this->vendorForm->id]);

        $this->withoutMiddleware([ValidateCsrfToken::class])
            ->from($url)
            ->post($url, [])
            ->assertSessionHasErrors('responses');
    });

    it('returns 404 when no vendor form matches the vid', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('sig');
        $responses = [];
        for ($i = 1; $i <= 22; $i++) {
            $responses[$i] = ['response' => 'yes', 'comment' => null];
        }

        $url = URL::signedRoute('dealer.vendor.submit', ['vid' => 999999]);

        $this->withoutMiddleware([ValidateCsrfToken::class])
            ->post($url, ['signature' => $signature, 'responses' => $responses])
            ->assertNotFound();
    });
});

describe('thankyou page', function (): void {
    it('renders the Thankyou Inertia page', function (): void {
        $this->get(route('dealer.vendors.thankyou'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/vendor/Thankyou'));
    });
});
