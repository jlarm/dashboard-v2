<?php

declare(strict_types=1);

use App\Jobs\Manuals\GenerateIspManualJob;
use App\Jobs\Manuals\UploadIspToDigitaloceanJob;
use App\Models\Dealer\Manual\Isp;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
    $this->store = Store::query()->first();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

describe('GET manuals/isp', function (): void {
    it('renders the index page with current store and existing manuals', function (): void {
        $manual = Isp::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'isp-manual-20260101010101.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.isp.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/isp/Index')
                ->where('store.id', $this->store->id)
                ->where('manuals.0.id', $manual->id));
    });
});

describe('GET manuals/isp/create', function (): void {
    it('renders the create page with store-driven defaults', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.isp.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/isp/Create')
                ->where('defaults.store_id', $this->store->id));
    });
});

describe('POST manuals/isp', function (): void {
    beforeEach(function (): void {
        Bus::fake();
        Storage::fake();
    });

    it('persists the manual, saves the signature, and dispatches the PDF job chain', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.isp.create'))
            ->post(route('dealer.manual.isp.store'), ['signature' => $signature])
            ->assertRedirect(route('dealer.manual.isp.index'))
            ->assertSessionHas('success');

        expect(Isp::query()->where('store_id', $this->store->id)->count())->toBe(1);

        $manual = Isp::query()->where('store_id', $this->store->id)->first();

        expect(Storage::exists('isp-signatures/'.$manual->signature))->toBeTrue();

        Bus::assertChained([
            GenerateIspManualJob::class,
            UploadIspToDigitaloceanJob::class,
        ]);
    });

    it('rejects requests without a signature', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.isp.create'))
            ->post(route('dealer.manual.isp.store'), [])
            ->assertSessionHasErrors('signature');

        Bus::assertNothingDispatched();
    });

    it('rejects malformed signature payloads', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.isp.create'))
            ->post(route('dealer.manual.isp.store'), ['signature' => 'not-a-data-uri'])
            ->assertSessionHasErrors('signature');
    });
});

describe('DELETE manuals/isp/{manual}', function (): void {
    it('returns 404 when the manual belongs to a store outside the user scope', function (): void {
        $otherStore = Store::query()->create([
            'name' => 'Out-of-scope Store',
            'address' => '123 Elsewhere',
            'city' => 'Nowhere',
            'state' => 'NY',
            'zip' => '12345',
        ]);

        $manual = Isp::query()->create([
            'store_id' => $otherStore->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
        ]);

        $scopedUser = App\Models\User::query()->create([
            'name' => 'Scoped Owner',
            'email' => 'scoped-isp@test.com',
            'password' => bcrypt('password'),
            'current_store_id' => $this->store->id,
        ]);
        $scopedUser->assignRole('Owner');
        $scopedUser->stores()->sync([$this->store->id]);

        $this->actingAs($scopedUser)
            ->delete(route('dealer.manual.isp.destroy', ['manual' => $manual->id]))
            ->assertNotFound();

        expect(Isp::query()->find($manual->id))->not->toBeNull();
    });

    it('deletes the record and clears signature + PDF storage', function (): void {
        Storage::fake();

        $manual = Isp::query()->create([
            'store_id' => $this->store->id,
            'user_id' => $this->consultant->id,
            'signature' => 'sig.png',
            'pdf_path' => 'isp-manual-20260101010101.pdf',
        ]);

        Storage::put('isp-signatures/'.$manual->signature, 'png');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.isp.index'))
            ->delete(route('dealer.manual.isp.destroy', ['manual' => $manual->id]))
            ->assertRedirect(route('dealer.manual.isp.index'))
            ->assertSessionHas('success');

        expect(Isp::query()->find($manual->id))->toBeNull();
        expect(Storage::exists('isp-signatures/'.$manual->signature))->toBeFalse();
    });
});
