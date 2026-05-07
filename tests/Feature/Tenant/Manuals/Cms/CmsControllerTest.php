<?php

declare(strict_types=1);

use App\Jobs\Manuals\GenerateCmsManualJob;
use App\Jobs\Manuals\UploadCmsToDigitalOceanJob;
use App\Models\CmsManual;
use App\Models\Dealer\Store;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
    Storage::fake('do-manuals');
    $this->store = Store::query()->first();
    $this->store->update(['standard_dpp_rate' => '3.50']);
    $this->consultant->update(['current_store_id' => $this->store->id]);

    $this->qiUser = User::query()->create([
        'name' => 'CMS QI User',
        'email' => 'cms-qi@test.com',
        'password' => bcrypt('password'),
        'current_store_id' => $this->store->id,
    ]);
    $this->qiUser->assignRole('Qualified Individual');
    $this->qiUser->stores()->sync([$this->store->id]);
});

describe('GET manuals/cms', function (): void {
    it('renders the index page with current store and existing manuals', function (): void {
        $manual = CmsManual::query()->create([
            'user_id' => $this->consultant->id,
            'store_id' => $this->store->id,
            'qi_name' => 'CMS QI User',
            'standard_dpp_rate' => '3.50',
            'acknowledgement_name' => 'Tester',
            'acknowledgement_signature' => 'sig.png',
            'pdf_path' => 'cms-manual-20260101010101.pdf',
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.cms.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/cms/Index')
                ->where('store.id', $this->store->id)
                ->where('manuals.0.id', $manual->id));
    });
});

describe('GET manuals/cms/create', function (): void {
    it('renders the create page with three policy partials and store-driven defaults', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.manual.cms.create'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/manuals/cms/Create')
                ->where('defaults.store_id', $this->store->id)
                ->where('defaults.qualified_individual_name', 'CMS QI User')
                ->where('defaults.standard_dpp_rate', '3.50')
                ->where('introHtml', fn (string $html): bool => str_contains($html, 'Compliance Management System Program'))
                ->where('dppHtml', fn (string $html): bool => str_contains($html, 'Dealer Participation Program'))
                ->where('formExampleHtml', fn (string $html): bool => str_contains($html, 'Acknowledgement')));
    });
});

describe('POST manuals/cms', function (): void {
    beforeEach(function (): void {
        Bus::fake();
    });

    it('persists the manual, saves required signatures, and dispatches the PDF job chain', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');

        $payload = [
            'qi_name' => 'CMS QI User',
            'standard_dpp_rate' => '3.50',
            'acknowledgement_name' => 'Acknowledger',
            'acknowledgement_signature' => $signature,
        ];

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.cms.create'))
            ->post(route('dealer.manual.cms.store'), $payload)
            ->assertRedirect(route('dealer.manual.cms.index'))
            ->assertSessionHas('success');

        $manual = CmsManual::query()->where('store_id', $this->store->id)->first();

        expect($manual)->not->toBeNull();
        expect($manual->qi_name)->toBe('CMS QI User');
        expect($manual->acknowledgement_name)->toBe('Acknowledger');
        expect(Storage::exists('cms-signatures/'.$manual->acknowledgement_signature))->toBeTrue();

        Bus::assertChained([
            GenerateCmsManualJob::class,
            UploadCmsToDigitalOceanJob::class,
        ]);
    });

    it('persists optional adoption signatures when supplied', function (): void {
        $signature = 'data:image/png;base64,'.base64_encode('fake-png-bytes');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.cms.create'))
            ->post(route('dealer.manual.cms.store'), [
                'qi_name' => 'CMS QI User',
                'standard_dpp_rate' => '3.50',
                'adoption_approval_name_one' => 'Owner Name',
                'adoption_approval_signature_one' => $signature,
                'acknowledgement_name' => 'Acknowledger',
                'acknowledgement_signature' => $signature,
            ])
            ->assertRedirect(route('dealer.manual.cms.index'));

        $manual = CmsManual::query()->where('store_id', $this->store->id)->first();

        expect($manual->adoption_approval_name_one)->toBe('Owner Name');
        expect(Storage::exists('cms-signatures/'.$manual->adoption_approval_signature_one))->toBeTrue();
    });

    it('rejects requests missing required acknowledgement fields', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.cms.create'))
            ->post(route('dealer.manual.cms.store'), [
                'qi_name' => 'CMS QI User',
                'standard_dpp_rate' => '3.50',
            ])
            ->assertSessionHasErrors(['acknowledgement_name', 'acknowledgement_signature']);

        Bus::assertNothingDispatched();
    });

    it('rejects malformed signature payloads', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.cms.create'))
            ->post(route('dealer.manual.cms.store'), [
                'qi_name' => 'CMS QI User',
                'standard_dpp_rate' => '3.50',
                'acknowledgement_name' => 'Acknowledger',
                'acknowledgement_signature' => 'not-a-data-uri',
            ])
            ->assertSessionHasErrors('acknowledgement_signature');
    });
});

describe('DELETE manuals/cms/{manual}', function (): void {
    it('deletes the record and clears all signatures', function (): void {
        $manual = CmsManual::query()->create([
            'user_id' => $this->consultant->id,
            'store_id' => $this->store->id,
            'qi_name' => 'CMS QI User',
            'standard_dpp_rate' => '3.50',
            'acknowledgement_name' => 'Tester',
            'acknowledgement_signature' => 'ack.png',
            'adoption_approval_signature_one' => 'one.png',
            'pdf_path' => 'cms-manual-20260101010101.pdf',
        ]);

        Storage::put('cms-signatures/ack.png', 'png');
        Storage::put('cms-signatures/one.png', 'png');

        $this->actingAs($this->consultant)
            ->from(route('dealer.manual.cms.index'))
            ->delete(route('dealer.manual.cms.destroy', ['manual' => $manual->id]))
            ->assertRedirect(route('dealer.manual.cms.index'))
            ->assertSessionHas('success');

        expect(CmsManual::query()->find($manual->id))->toBeNull();
        expect(Storage::exists('cms-signatures/ack.png'))->toBeFalse();
        expect(Storage::exists('cms-signatures/one.png'))->toBeFalse();
    });
});
