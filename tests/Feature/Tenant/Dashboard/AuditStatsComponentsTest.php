<?php

declare(strict_types=1);

use App\Http\Livewire\Dealer\Home\BodyShopStats;
use App\Http\Livewire\Dealer\Home\DealJacketStats;
use App\Http\Livewire\Dealer\Home\GlbaStats;
use App\Http\Livewire\Dealer\Home\OshaStats;
use App\Jobs\Audit\GenerateDealJacketReportJob;
use App\Models\Dealer\Audit\BodyShopViolationAudit;
use App\Models\Dealer\Audit\DealJacketGroup;
use App\Models\Dealer\Audit\GlbaViolationAudit;
use App\Models\Dealer\Audit\OshaViolationAudit;
use App\Models\Dealer\Store;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->store = Store::query()->firstOrFail();
    $this->actingAs($this->consultant);
});

it('uses the latest osha audit by date and id and downloads its report', function (): void {
    Storage::fake('armpaudits');

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-01-10',
        'grade' => 'C',
        'pdf_path' => 'osha/older.pdf',
    ]);

    OshaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-01-10',
        'grade' => 'A',
        'pdf_path' => 'osha/latest.pdf',
    ]);

    Storage::disk('armpaudits')->put('osha/latest.pdf', 'pdf');

    $component = Livewire::test(OshaStats::class, ['store' => $this->store]);

    expect($component->instance()->rating())->toBe('A');
    expect($component->instance()->pdfPath())->toBe('osha/latest.pdf');

    $response = $component->call('downloadPdf');
    expect($response->payload['effects']['download']['name'])->toBe('latest.pdf');
});

it('uses the latest body shop audit and downloads its report', function (): void {
    Storage::fake('armpaudits');

    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-01-01',
        'grade' => 'D',
        'pdf_path' => 'body-shop/older.pdf',
    ]);

    BodyShopViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-02-01',
        'grade' => 'B',
        'pdf_path' => 'body-shop/latest.pdf',
    ]);

    Storage::disk('armpaudits')->put('body-shop/latest.pdf', 'pdf');

    $component = Livewire::test(BodyShopStats::class, ['store' => $this->store]);

    expect($component->instance()->rating())->toBe('B');
    expect($component->instance()->pdfPath())->toBe('body-shop/latest.pdf');

    $response = $component->call('downloadPdf');
    expect($response->payload['effects']['download']['name'])->toBe('latest.pdf');
});

it('uses the latest glba audit and downloads its report', function (): void {
    Storage::fake('armpaudits');

    GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-01-01',
        'grade' => 'F',
        'pdf_path' => 'glba/older.pdf',
    ]);

    GlbaViolationAudit::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $this->consultant->id,
        'store_id' => $this->store->id,
        'date' => '2026-02-01',
        'grade' => 'A',
        'pdf_path' => 'glba/latest.pdf',
    ]);

    Storage::disk('armpaudits')->put('glba/latest.pdf', 'pdf');

    $component = Livewire::test(GlbaStats::class, ['store' => $this->store]);

    expect($component->instance()->rating())->toBe('A');
    expect($component->instance()->pdfPath())->toBe('glba/latest.pdf');

    $response = $component->call('downloadPdf');
    expect($response->payload['effects']['download']['name'])->toBe('latest.pdf');
});

it('generates the latest completed deal jacket report and downloads it', function (): void {
    Storage::fake('local');
    Bus::fake();

    $oldCompleted = DealJacketGroup::factory()->create([
        'store_id' => $this->store->id,
        'completed' => true,
    ]);
    $oldCompleted->update(['created_at' => now()->subDay(), 'updated_at' => now()->subDay()]);

    $latestCompleted = DealJacketGroup::factory()->create([
        'store_id' => $this->store->id,
        'completed' => true,
    ]);

    DealJacketGroup::factory()->create([
        'store_id' => $this->store->id,
        'completed' => false,
    ]);

    $fileName = $latestCompleted->created_at->format('Ymd-His').'-'.
        str_replace(' ', '-', $this->store->name).'-deal-jacket-report.pdf';

    Storage::put("deal-jacket-reports/{$fileName}", 'pdf');

    $response = Livewire::test(DealJacketStats::class, ['store' => $this->store])
        ->call('download');

    Bus::assertDispatchedSync(GenerateDealJacketReportJob::class);
    expect($response->payload['effects']['download']['name'])->toBe($fileName);
});
