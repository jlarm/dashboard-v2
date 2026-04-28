<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\DealerDoc;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    Storage::fake('dealer-docs');

    $this->employee = User::factory()->create();
    $this->employee->assignRole('Employee');

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('DealerDoc index', function (): void {
    it('rejects employees from accessing the page', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.doc.index'))
            ->assertForbidden();
    });

    it('rejects porter/drivers from accessing the page', function (): void {
        $porter = User::factory()->create();
        $porter->assignRole('Porter/Driver');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($porter)
            ->get(route('dealer.doc.index'))
            ->assertForbidden();
    });

    it('hides the create button for non-consultants', function (): void {
        $owner = User::factory()->create();
        $owner->assignRole('Owner');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($owner)
            ->get(route('dealer.doc.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/document/Index')
                ->where('can.create', false));
    });

    it('renders the inertia page with dealer docs sorted by title', function (): void {
        $store = Store::query()->firstOrFail();

        DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Zeta Handbook',
            'url' => null,
            'file_name' => 'zeta.pdf',
            'file_path' => 'tenant/zeta.pdf',
        ]);
        DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Alpha Handbook',
            'url' => 'https://example.com',
            'file_name' => '',
            'file_path' => '',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/document/Index')
                ->has('docs.data', 2)
                ->where('docs.data.0.title', 'Alpha Handbook')
                ->where('docs.data.1.title', 'Zeta Handbook')
                ->where('docs.meta.total', 2)
                ->where('filters.search', null)
                ->where('can.create', true));
    });

    it('filters by search term', function (): void {
        $store = Store::query()->firstOrFail();

        DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Brake Cleaner Handbook',
            'file_name' => '',
            'file_path' => '',
            'url' => 'https://example.com',
        ]);
        DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Oil Treatment Handbook',
            'file_name' => '',
            'file_path' => '',
            'url' => 'https://example.com',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.index', ['search' => 'brake']))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('docs.data', 1)
                ->where('docs.data.0.title', 'Brake Cleaner Handbook')
                ->where('filters.search', 'brake'));
    });

    it('paginates results', function (): void {
        $store = Store::query()->firstOrFail();

        foreach (range(1, 20) as $i) {
            DealerDoc::query()->create([
                'store_id' => $store->id,
                'title' => sprintf('Doc %02d', $i),
                'file_name' => '',
                'file_path' => '',
                'url' => 'https://example.com',
            ]);
        }

        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('docs.data', 15)
                ->where('docs.meta.total', 20)
                ->where('docs.meta.current_page', 1)
                ->where('docs.meta.last_page', 2));

        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.index', ['page' => 2]))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('docs.data', 5)
                ->where('docs.meta.current_page', 2));
    });
});

describe('DealerDoc store', function (): void {
    it('rejects employees', function (): void {
        $this->actingAs($this->employee)
            ->post(route('dealer.doc.store'), [
                'title' => 'Forbidden',
                'file' => UploadedFile::fake()->create('forbidden.pdf', 10, 'application/pdf'),
            ])
            ->assertForbidden();

        expect(DealerDoc::query()->count())->toBe(0);
    });

    it('rejects owners (only super-admin and Consultant may upload)', function (): void {
        $owner = User::factory()->create();
        $owner->assignRole('Owner');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($owner)
            ->post(route('dealer.doc.store'), [
                'title' => 'Forbidden',
                'file' => UploadedFile::fake()->create('forbidden.pdf', 10, 'application/pdf'),
            ])
            ->assertForbidden();

        expect(DealerDoc::query()->count())->toBe(0);
    });

    it('uploads a PDF and creates a dealer doc', function (): void {
        $file = UploadedFile::fake()->create('handbook.pdf', 100, 'application/pdf');

        $this->actingAs($this->consultant)
            ->post(route('dealer.doc.store'), [
                'title' => 'Handbook',
                'file' => $file,
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $doc = DealerDoc::query()->firstOrFail();
        expect($doc->title)->toBe('Handbook')
            ->and($doc->file_name)->toBe('handbook.pdf');
        Storage::disk('dealer-docs')->assertExists($doc->file_path);
    });

    it('requires a url or a file', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.doc.store'), ['title' => 'Title only'])
            ->assertSessionHasErrors('file');

        expect(DealerDoc::query()->count())->toBe(0);
    });

    it('rejects non-pdf uploads', function (): void {
        $this->actingAs($this->consultant)
            ->post(route('dealer.doc.store'), [
                'title' => 'Bad file',
                'file' => UploadedFile::fake()->create('image.png', 50, 'image/png'),
            ])
            ->assertSessionHasErrors('file');
    });
});

describe('DealerDoc destroy', function (): void {
    it('deletes the doc and its stored file', function (): void {
        $store = Store::query()->firstOrFail();
        Storage::disk('dealer-docs')->put('tenant/handbook.pdf', 'pdf');

        $doc = DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Handbook',
            'file_name' => 'handbook.pdf',
            'file_path' => 'tenant/handbook.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->delete(route('dealer.doc.destroy', $doc))
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        expect(DealerDoc::query()->find($doc->id))->toBeNull();
        Storage::disk('dealer-docs')->assertMissing('tenant/handbook.pdf');
    });

    it('rejects owners (only super-admin and Consultant may delete)', function (): void {
        $store = Store::query()->firstOrFail();
        $owner = User::factory()->create();
        $owner->assignRole('Owner');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $doc = DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Handbook',
            'file_name' => '',
            'file_path' => '',
            'url' => 'https://example.com',
        ]);

        $this->actingAs($owner)
            ->delete(route('dealer.doc.destroy', $doc))
            ->assertForbidden();

        expect(DealerDoc::query()->find($doc->id))->not->toBeNull();
    });
});

describe('DealerDoc download', function (): void {
    it('streams the file from the dealer-docs disk', function (): void {
        $store = Store::query()->firstOrFail();
        Storage::disk('dealer-docs')->put('tenant/handbook.pdf', 'pdf-bytes');

        $doc = DealerDoc::query()->create([
            'store_id' => $store->id,
            'title' => 'Handbook',
            'file_name' => 'handbook.pdf',
            'file_path' => 'tenant/handbook.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.doc.download', $doc))
            ->assertOk();
    });
});
