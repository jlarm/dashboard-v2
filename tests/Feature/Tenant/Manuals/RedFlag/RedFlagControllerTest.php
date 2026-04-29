<?php

declare(strict_types=1);

use App\Jobs\Manuals\GenerateRedFlagManualJob;
use App\Jobs\Manuals\UploadRedFlagToDigitalOceanJob;
use App\Models\Dealer\Manual\RedFlag;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
    $this->store = Store::query()->first();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

describe('GET manuals/red-flag', function (): void {
    it('renders the index page with current store and existing manuals', function (): void {
        $manual = RedFlag::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'red-flag-manual-20260101010101.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.red-flag.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/red-flag/Index')
                ->where('store.id', $this->store->id)
                ->where('manuals.0.id', $manual->id));
    });
});

describe('GET manuals/red-flag/create', function (): void {
    it('renders the create page with policy HTML and store-driven defaults', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.red-flag.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/red-flag/Create')
                ->where('defaults.store_id', $this->store->id)
                ->where('policyHtml', fn (string $html) => str_contains($html, 'Red Flag Rule')));
    });
});

describe('POST manuals/red-flag', function (): void {
    beforeEach(function (): void {
        Bus::fake();
    });

    it('persists the manual, saves the signature, and dispatches the PDF job chain', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.red-flag.create'))
            ->post(route('dealer.manual.red-flag.store'), ['signature' => $signature])
            ->assertRedirect(route('dealer.manual.red-flag.index'))
            ->assertSessionHas('success');

        expect(RedFlag::query()->where('store_id', $this->store->id)->count())->toBe(1);

        $manual = RedFlag::query()->where('store_id', $this->store->id)->first();

        expect(Storage::exists('red-flag-signatures/'.$manual->signature))->toBeTrue();

        Bus::assertChained([
            GenerateRedFlagManualJob::class,
            UploadRedFlagToDigitalOceanJob::class,
        ]);
    });

    it('rejects requests without a signature', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.red-flag.create'))
            ->post(route('dealer.manual.red-flag.store'), [])
            ->assertSessionHasErrors('signature');

        Bus::assertNothingDispatched();
    });

    it('rejects malformed signature payloads', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.red-flag.create'))
            ->post(route('dealer.manual.red-flag.store'), ['signature' => 'not-a-data-uri'])
            ->assertSessionHasErrors('signature');
    });
});

describe('DELETE manuals/red-flag/{manual}', function (): void {
    it('deletes the record and clears signature + PDF storage', function (): void {
        $manual = RedFlag::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'red-flag-manual-20260101010101.pdf',
        ]);

        Storage::put('red-flag-signatures/'.$manual->signature, 'png');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.red-flag.index'))
            ->delete(route('dealer.manual.red-flag.destroy', ['manual' => $manual->id]))
            ->assertRedirect(route('dealer.manual.red-flag.index'))
            ->assertSessionHas('success');

        expect(RedFlag::query()->find($manual->id))->toBeNull();
        expect(Storage::exists('red-flag-signatures/'.$manual->signature))->toBeFalse();
    });
});
