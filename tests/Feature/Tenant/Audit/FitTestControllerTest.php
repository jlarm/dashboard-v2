<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Models\FitTestDoc;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    Storage::fake('dealer-docs');

    $this->store = Store::query()->firstOrFail();

    $this->superAdmin = User::factory()->create(['current_store_id' => $this->store->id]);
    $this->superAdmin->assignRole('super-admin');
    $this->superAdmin->stores()->sync([$this->store->id]);

    $this->manager->update(['current_store_id' => $this->store->id]);
    $this->manager->stores()->sync([$this->store->id]);

    $this->employee = User::factory()->create(['current_store_id' => $this->store->id]);
    $this->employee->assignRole('Employee');
    $this->employee->stores()->sync([$this->store->id]);

    app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
});

describe('fit test index', function (): void {
    it('renders the inertia page for managers', function (): void {
        $this->actingAs($this->manager)
            ->get(route('dealer.fit-tests.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/audit/FitTests')
                ->where('can.manage', false)
                ->has('employees', 0));
    });

    it('rejects employees outside the manager role group', function (): void {
        $this->actingAs($this->employee)
            ->get(route('dealer.fit-tests.index'))
            ->assertForbidden();
    });

    it('lists fit tests for the current store with the manage affordances', function (): void {
        FitTestDoc::factory()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->employee->id,
            'employee_name' => 'Jane Doe',
            'date' => '2026-01-10',
            'file_path' => 'test-tenant/fits/jane.pdf',
        ]);

        $this->actingAs($this->superAdmin)
            ->get(route('dealer.fit-tests.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/audit/FitTests')
                ->where('can.manage', true)
                ->has('fitTests', 1)
                ->where('fitTests.0.employee_name', 'Jane Doe')
                ->has('employees'));
    });
});

describe('fit test store', function (): void {
    it('uploads a pdf and creates a fit test', function (): void {
        $file = UploadedFile::fake()->create('fit.pdf', 100, 'application/pdf');

        $this->actingAs($this->superAdmin)
            ->post(route('dealer.fit-tests.store'), [
                'user_id' => $this->employee->id,
                'date' => '2026-02-01',
                'file' => $file,
            ])
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        $doc = FitTestDoc::query()->firstOrFail();
        expect($doc->store_id)->toBe($this->store->id)
            ->and($doc->user_id)->toBe($this->employee->id)
            ->and($doc->employee_name)->toBe($this->employee->name);
        Storage::disk('dealer-docs')->assertExists($doc->file_path);
    });

    it('rejects managers without the create-dealerships permission', function (): void {
        $this->actingAs($this->manager)
            ->post(route('dealer.fit-tests.store'), [
                'user_id' => $this->employee->id,
                'date' => '2026-02-01',
                'file' => UploadedFile::fake()->create('fit.pdf', 100, 'application/pdf'),
            ])
            ->assertForbidden();

        expect(FitTestDoc::query()->count())->toBe(0);
    });

    it('requires a file', function (): void {
        $this->actingAs($this->superAdmin)
            ->post(route('dealer.fit-tests.store'), [
                'user_id' => $this->employee->id,
                'date' => '2026-02-01',
            ])
            ->assertSessionHasErrors('file');

        expect(FitTestDoc::query()->count())->toBe(0);
    });

    it('rejects non-pdf uploads', function (): void {
        $this->actingAs($this->superAdmin)
            ->post(route('dealer.fit-tests.store'), [
                'user_id' => $this->employee->id,
                'date' => '2026-02-01',
                'file' => UploadedFile::fake()->create('image.png', 50, 'image/png'),
            ])
            ->assertSessionHasErrors('file');

        expect(FitTestDoc::query()->count())->toBe(0);
    });
});

describe('fit test destroy', function (): void {
    it('deletes the doc and its stored file', function (): void {
        Storage::disk('dealer-docs')->put('test-tenant/fits/jane.pdf', 'pdf');

        $doc = FitTestDoc::factory()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->employee->id,
            'file_path' => 'test-tenant/fits/jane.pdf',
        ]);

        $this->actingAs($this->superAdmin)
            ->delete(route('dealer.fit-tests.destroy', $doc))
            ->assertRedirect()
            ->assertSessionHas('flash.success');

        expect(FitTestDoc::query()->find($doc->id))->toBeNull();
        Storage::disk('dealer-docs')->assertMissing('test-tenant/fits/jane.pdf');
    });

    it('rejects managers without the create-dealerships permission', function (): void {
        $doc = FitTestDoc::factory()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->employee->id,
        ]);

        $this->actingAs($this->manager)
            ->delete(route('dealer.fit-tests.destroy', $doc))
            ->assertForbidden();

        expect(FitTestDoc::query()->find($doc->id))->not->toBeNull();
    });
});

describe('fit test download', function (): void {
    it('streams the file from the dealer-docs disk', function (): void {
        Storage::disk('dealer-docs')->put('test-tenant/fits/jane.pdf', 'pdf-bytes');

        $doc = FitTestDoc::factory()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->employee->id,
            'file_path' => 'test-tenant/fits/jane.pdf',
        ]);

        $this->actingAs($this->superAdmin)
            ->get(route('dealer.fit-tests.download', $doc))
            ->assertOk();
    });

    it('returns a 404 when the file is missing on disk', function (): void {
        $doc = FitTestDoc::factory()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->employee->id,
            'file_path' => 'test-tenant/fits/missing.pdf',
        ]);

        $this->actingAs($this->superAdmin)
            ->get(route('dealer.fit-tests.download', $doc))
            ->assertNotFound();
    });
});
