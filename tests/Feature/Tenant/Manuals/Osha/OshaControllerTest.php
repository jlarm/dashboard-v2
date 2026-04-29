<?php

declare(strict_types=1);

use App\Jobs\Manuals\GenerateOshaManualJob;
use App\Jobs\Manuals\UploadOshaToDigitalOceanJob;
use App\Models\Dealer\Manual\Osha;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
    $this->store = Store::query()->first();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

describe('GET manuals/osha', function (): void {
    it('renders the index page with current store and existing manuals', function (): void {
        $manual = Osha::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'osha-manual-20260101010101.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.osha.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/osha/Index')
                ->where('store.id', $this->store->id)
                ->where('manuals.0.id', $manual->id));
    });
});

describe('GET manuals/osha/create', function (): void {
    it('renders the create page with policy HTML and store-driven defaults', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.osha.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/osha/Create')
                ->where('defaults.store_id', $this->store->id)
                ->where('policyHtml', fn (string $html) => str_contains($html, 'Emergency Action Plan')));
    });
});

describe('POST manuals/osha', function (): void {
    beforeEach(function (): void {
        Bus::fake();
    });

    it('persists the manual, saves the signature, and dispatches the PDF job chain', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.osha.create'))
            ->post(route('dealer.manual.osha.store'), ['signature' => $signature])
            ->assertRedirect(route('dealer.manual.osha.index'))
            ->assertSessionHas('success');

        expect(Osha::query()->where('store_id', $this->store->id)->count())->toBe(1);

        $manual = Osha::query()->where('store_id', $this->store->id)->first();

        expect(Storage::exists('osha-signatures/'.$manual->signature))->toBeTrue();

        Bus::assertChained([
            GenerateOshaManualJob::class,
            UploadOshaToDigitalOceanJob::class,
        ]);
    });

    it('rejects requests without a signature', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.osha.create'))
            ->post(route('dealer.manual.osha.store'), [])
            ->assertSessionHasErrors('signature');

        Bus::assertNothingDispatched();
    });

    it('rejects malformed signature payloads', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.osha.create'))
            ->post(route('dealer.manual.osha.store'), ['signature' => 'not-a-data-uri'])
            ->assertSessionHasErrors('signature');
    });
});

describe('DELETE manuals/osha/{manual}', function (): void {
    it('deletes the record and clears signature + PDF storage', function (): void {
        $manual = Osha::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'osha-manual-20260101010101.pdf',
        ]);

        Storage::put('osha-signatures/'.$manual->signature, 'png');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.osha.index'))
            ->delete(route('dealer.manual.osha.destroy', ['manual' => $manual->id]))
            ->assertRedirect(route('dealer.manual.osha.index'))
            ->assertSessionHas('success');

        expect(Osha::query()->find($manual->id))->toBeNull();
        expect(Storage::exists('osha-signatures/'.$manual->signature))->toBeFalse();
    });
});
