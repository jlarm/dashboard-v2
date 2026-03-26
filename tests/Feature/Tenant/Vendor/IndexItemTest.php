<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Vendor\IndexItem;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->vendor = Vendor::query()->create([
        'name' => 'Test Vendor',
        'contact_name' => 'John Doe',
        'contact_email' => 'john@vendor.com',
    ]);
});

it('reports not completed when vendor has no forms', function (): void {
    $this->actingAs($this->consultant);

    Livewire::test(IndexItem::class, ['vendor' => $this->vendor])
        ->assertSet('vendor', $this->vendor)
        ->assertStatus(200);

    expect($this->vendor->latestForm)->toBeNull();
});

it('reports not completed when latest form has no signature or document', function (): void {
    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
        'signature' => null,
        'document_path' => null,
    ]);

    $this->vendor->load('latestForm');

    $this->actingAs($this->consultant);

    $component = Livewire::test(IndexItem::class, ['vendor' => $this->vendor]);

    expect($component->instance()->isCompleted())->toBeFalse();
});

it('reports completed when latest form has a signature', function (): void {
    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
        'signature' => 'signature.png',
        'document_path' => null,
    ]);

    $this->vendor->load('latestForm');

    $this->actingAs($this->consultant);

    $component = Livewire::test(IndexItem::class, ['vendor' => $this->vendor]);

    expect($component->instance()->isCompleted())->toBeTrue();
});

it('reports completed when latest form has a document path', function (): void {
    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
        'signature' => null,
        'document_path' => 'vendor-documents/form.pdf',
    ]);

    $this->vendor->load('latestForm');

    $this->actingAs($this->consultant);

    $component = Livewire::test(IndexItem::class, ['vendor' => $this->vendor]);

    expect($component->instance()->isCompleted())->toBeTrue();
});

it('latestForm relationship returns the most recent form', function (): void {
    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Old Form',
        'email' => 'john@vendor.com',
        'signature' => 'old.png',
        'created_at' => now()->subDays(2),
    ]);

    $newest = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'New Form',
        'email' => 'john@vendor.com',
        'signature' => null,
        'document_path' => null,
        'created_at' => now()->subDay(),
    ]);

    $this->vendor->load('latestForm');

    expect($this->vendor->latestForm->id)->toBe($newest->id);
});

it('latestForm is eagerly loadable alongside store', function (): void {
    VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'John Doe',
        'email' => 'john@vendor.com',
        'signature' => 'sig.png',
    ]);

    $vendors = Vendor::with(['latestForm'])->get();

    expect($vendors->first()->relationLoaded('latestForm'))->toBeTrue();
    expect($vendors->first()->latestForm)->not->toBeNull();
});
