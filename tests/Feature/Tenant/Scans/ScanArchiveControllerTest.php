<?php

declare(strict_types=1);

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;

beforeEach(function (): void {
    $this->store = Store::query()->first();
    $this->consultant->update(['current_store_id' => $this->store->id]);
});

describe('GET scans-archive', function (): void {
    it('renders the Inertia archive page with grouped reports and stats', function (): void {
        ScanReport::query()->create([
            'user_id' => $this->consultant->id,
            'store_id' => $this->store->id,
            'path' => 'reports/external-2026-04-15-exec.pdf',
            'scan_type' => 'external',
            'type' => 'executive',
            'grade' => 'B',
            'exploits_high' => 3,
            'exploits_medium' => 5,
            'exploits_low' => 8,
            'cves_high' => 1,
            'cves_medium' => 2,
            'cves_low' => 4,
        ]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.archive'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/scans/Archive')
                ->where('store.id', $this->store->id)
                ->where('externalStats.grade', 'B')
                ->where('externalStats.exploits.high', 3)
                ->where('externalStats.cves.medium', 2)
                ->has('externalReports'));
    });

    it('flags canUpload true for users with the create-dealerships permission', function (): void {
        $this->consultant->givePermissionTo('create-dealerships');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.archive'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page->where('canUpload', true));
    });

});

describe('POST scans-archive/upload', function (): void {
    beforeEach(function (): void {
        Storage::fake('do-scans');
        $this->consultant->givePermissionTo('create-dealerships');
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
    });

    it('stores the file and creates a ScanReport row', function (): void {
        $file = UploadedFile::fake()->create('external-report.pdf', 100, 'application/pdf');

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.archive'))
            ->post(route('dealer.scan.archive.upload'), [
                'scan_type' => 'external',
                'summary_type' => 'technical',
                'date' => '2026-04-01',
                'file' => $file,
            ])
            ->assertRedirect(route('dealer.scan.archive'))
            ->assertSessionHas('flash.success');

        expect(ScanReport::query()->where('store_id', $this->store->id)->where('scan_type', 'external')->where('type', 'technical')->count())->toBe(1);
    });

    it('rejects non-PDF uploads', function (): void {
        $file = UploadedFile::fake()->create('not-a-pdf.txt', 1, 'text/plain');

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.archive'))
            ->post(route('dealer.scan.archive.upload'), [
                'scan_type' => 'external',
                'summary_type' => 'executive',
                'file' => $file,
            ])
            ->assertSessionHasErrors('file');
    });

});
