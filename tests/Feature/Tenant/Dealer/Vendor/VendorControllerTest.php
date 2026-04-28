<?php

declare(strict_types=1);

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Vendor;
use App\Models\User;
use App\Notifications\VendorSignedNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    Storage::fake('do-manuals');
    Storage::fake('local');
});

describe('vendor index', function (): void {
    it('renders the inertia page for super-admin', function (): void {
        $this->consultant->syncRoles('super-admin');

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/vendor/Index')
                ->has('vendors.data')
                ->has('vendors.meta.total')
                ->has('filters.search')
                ->has('stores')
                ->has('hasQualifiedIndividual'));
    });

    it('filters vendors by search term', function (): void {
        Vendor::query()->create(['name' => 'Acme Industries', 'contact_name' => 'Alice', 'contact_email' => 'alice@acme.test']);
        Vendor::query()->create(['name' => 'Beta Holdings', 'contact_name' => 'Bob', 'contact_email' => 'bob@beta.test']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index', ['search' => 'acme']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->where('filters.search', 'acme')
                ->has('vendors.data', 1)
                ->where('vendors.data.0.name', 'Acme Industries'));
    });

    it('paginates vendors at 16 per page', function (): void {
        for ($i = 1; $i <= 20; $i++) {
            Vendor::query()->create([
                'name' => sprintf('Vendor %02d', $i),
                'contact_name' => 'Contact '.$i,
                'contact_email' => "v{$i}@test.test",
            ]);
        }

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('vendors.data', 16)
                ->where('vendors.meta.total', 20)
                ->where('vendors.meta.last_page', 2));
    });

    it('renders for qualifying roles', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/vendor/Index'));
    })->with(['Admin', 'Consultant', 'Owner', 'GM', 'CFO', 'GSM', 'Qualified Individual', 'Manager']);

    it('forbids Employees and Porter/Drivers', function (string $role): void {
        $this->consultant->syncRoles($role);

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.index'))
            ->assertForbidden();
    })->with(['Employee', 'Porter/Driver']);

    it('redirects guests to login', function (): void {
        $this->get(route('dealer.vendor.index'))
            ->assertRedirect(route('dealer.login'));
    });
});

describe('vendor store', function (): void {
    it('creates a vendor and dispatches the email job', function (): void {
        Bus::fake();

        $this->actingAs($this->consultant)
            ->post(route('dealer.vendor.store'), [
                'name' => 'Acme Inc',
                'contact_name' => 'Jane Doe',
                'contact_email' => 'jane@acme.test',
            ])
            ->assertRedirect();

        $vendor = Vendor::query()->where('name', 'Acme Inc')->firstOrFail();

        expect($vendor->forms)->toHaveCount(1);
        Bus::assertDispatched(SendVendorEmailJob::class);
    });

    it('rejects non-qualifying roles', function (): void {
        $this->consultant->syncRoles('Employee');

        $this->actingAs($this->consultant)
            ->post(route('dealer.vendor.store'), [
                'name' => 'Bad Co',
                'contact_name' => 'X',
                'contact_email' => 'x@x.test',
            ])
            ->assertForbidden();
    });

    it('rejects an invalid contact email', function (string $email): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.vendor.store'), [
                'name' => 'Email Validation Co',
                'contact_name' => 'Jane',
                'contact_email' => $email,
            ])
            ->assertSessionHasErrors('contact_email');

        expect(Vendor::query()->where('name', 'Email Validation Co')->exists())->toBeFalse();
    })->with(['', 'not-an-email', 'jane@', '@example.com', 'jane example.com']);
});

describe('vendor show', function (): void {
    it('renders detail page with forms list', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'Showme',
            'contact_name' => 'C',
            'contact_email' => 'c@s.test',
        ]);
        $vendor->forms()->create(['name' => 'C', 'email' => 'c@s.test']);

        $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.show', ['vendor' => $vendor->id]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/vendor/Show')
                ->where('vendor.id', $vendor->id)
                ->has('forms', 1));
    });
});

describe('vendor destroy', function (): void {
    it('soft deletes a vendor', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'Delete Me',
            'contact_name' => 'C',
            'contact_email' => 'c@s.test',
        ]);

        $this->actingAs($this->consultant)
            ->delete(route('dealer.vendor.destroy', ['vendor' => $vendor->id]))
            ->assertRedirect(route('dealer.vendor.index'));

        expect(Vendor::query()->find($vendor->id))->toBeNull();
    });
});

describe('public vendor form', function (): void {
    it('renders the inertia public form for an unsigned VendorForm', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'Public Vendor',
            'contact_name' => 'Pub',
            'contact_email' => 'pub@v.test',
        ]);
        $vendorForm = $vendor->forms()->create(['name' => 'Pub', 'email' => 'pub@v.test']);

        $url = URL::temporarySignedRoute('dealer.vendor.form', now()->addDay(), [
            'vid' => $vendorForm->id,
            'email' => 'pub@v.test',
        ]);

        $this->get($url)
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/vendor/PublicForm')
                ->where('vendorForm.id', $vendorForm->id)
                ->has('questions'));
    });

    it('redirects to thank-you if the form is already signed', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'Signed Vendor',
            'contact_name' => 'S',
            'contact_email' => 's@v.test',
        ]);
        $vendorForm = $vendor->forms()->create([
            'name' => 'S',
            'email' => 's@v.test',
            'signature' => 'signed.png',
        ]);

        $url = URL::temporarySignedRoute('dealer.vendor.form', now()->addDay(), [
            'vid' => $vendorForm->id,
            'email' => 's@v.test',
        ]);

        $this->get($url)->assertRedirect(route('dealer.vendors.thankyou'));
    });

    it('rejects requests without a valid signature', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'Unsigned',
            'contact_name' => 'U',
            'contact_email' => 'u@v.test',
        ]);
        $vendorForm = $vendor->forms()->create(['name' => 'U', 'email' => 'u@v.test']);

        $this->get(route('dealer.vendor.form', ['vid' => $vendorForm->id]))
            ->assertForbidden();
    });

    it('accepts a document upload submission', function (): void {
        Notification::fake();

        $qi = User::query()->create(['name' => 'QI', 'email' => 'qi@v.test', 'password' => bcrypt('x')]);
        $qi->assignRole('Qualified Individual');

        $vendor = Vendor::query()->create([
            'name' => 'Doc Vendor',
            'contact_name' => 'D',
            'contact_email' => 'd@v.test',
        ]);
        $vendorForm = $vendor->forms()->create(['name' => 'D', 'email' => 'd@v.test']);

        $url = URL::temporarySignedRoute('dealer.vendor.form', now()->addDay(), [
            'vid' => $vendorForm->id,
            'email' => 'd@v.test',
        ]);

        $this->post($url, [
            'document' => UploadedFile::fake()->create('policy.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('dealer.vendors.thankyou'));

        $vendorForm->refresh();
        expect($vendorForm->document_path)->not->toBeNull();
        Notification::assertSentTo($qi, VendorSignedNotification::class);
    });

    it('accepts a signed responses submission', function (): void {
        Notification::fake();

        $qi = User::query()->create(['name' => 'QI', 'email' => 'qi@v.test', 'password' => bcrypt('x')]);
        $qi->assignRole('Qualified Individual');

        $vendor = Vendor::query()->create([
            'name' => 'Sig Vendor',
            'contact_name' => 'S',
            'contact_email' => 's@v.test',
        ]);
        $vendorForm = $vendor->forms()->create(['name' => 'S', 'email' => 's@v.test']);

        $url = URL::temporarySignedRoute('dealer.vendor.form', now()->addDay(), [
            'vid' => $vendorForm->id,
            'email' => 's@v.test',
        ]);

        $responses = [];
        for ($i = 1; $i <= 22; $i++) {
            $responses[$i] = ['response' => 'yes', 'comment' => null];
        }

        $signature = 'data:image/png;base64,'.base64_encode('sig-data');

        $this->post($url, [
            'signature' => $signature,
            'responses' => $responses,
        ])->assertRedirect(route('dealer.vendors.thankyou'));

        $vendorForm->refresh();
        expect($vendorForm->signature)->not->toBeNull();
        expect($vendorForm->data)->toHaveCount(22);
        Notification::assertSentTo($qi, VendorSignedNotification::class);
    });
});

describe('vendor thank you', function (): void {
    it('renders the public thank you page', function (): void {
        $this->get(route('dealer.vendors.thankyou'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->component('tenant/vendor/Thankyou'));
    });
});

describe('download vendor form', function (): void {
    it('streams an uploaded document', function (): void {
        $vendor = Vendor::query()->create([
            'name' => 'DL Vendor',
            'contact_name' => 'D',
            'contact_email' => 'd@v.test',
        ]);
        $path = tenant('id').'/vendor-documents/policy.pdf';
        Storage::disk('do-manuals')->put($path, 'pdf bytes');

        $vendorForm = $vendor->forms()->create([
            'name' => 'D',
            'email' => 'd@v.test',
            'document_path' => $path,
        ]);

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.vendor.forms.download', ['vendorForm' => $vendorForm->id]));

        $response->assertOk();
        expect($response->headers->get('content-type'))->toContain('application/pdf');
    });
});
