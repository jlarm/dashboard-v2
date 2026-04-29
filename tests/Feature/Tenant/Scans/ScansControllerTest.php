<?php

declare(strict_types=1);

use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

beforeEach(function (): void {
    Cache::flush();
    $this->store = Store::query()->first();
});

describe('GET scans (Inertia)', function (): void {
    it('renders the dashboard mode for a single-store consultant', function (): void {
        $this->consultant->update(['current_store_id' => $this->store->id]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('tenant/scans/Index')
                ->where('mode', 'dashboard')
                ->where('store.id', $this->store->id));
    });

    it('redirects to dashboard when current_store_id is null with multi-store locations enabled', function (): void {
        tenant()->update(['locations' => true]);

        Store::query()->create([
            'name' => 'Second Route Store',
            'slug' => 'second-route-store',
        ]);

        $this->consultant->update(['current_store_id' => null]);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.index'))
            ->assertRedirect(route('dealer.dashboard'));
    });
});

describe('POST scans/queue-report', function (): void {
    beforeEach(function (): void {
        Queue::fake();
        $this->consultant->update(['current_store_id' => $this->store->id]);
    });

    it('dispatches the GenerateCyrismaReportJob with a queued status', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.index'))
            ->post(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertRedirect(route('dealer.scan.index'))
            ->assertSessionHas('flash.success');

        Queue::assertPushed(GenerateCyrismaReportJob::class);
    });

    it('flashes a "ready" message when the report is already cached', function (): void {
        Cache::put(sprintf('cyrisma_report_pdf_v2_%d_executive', $this->store->id), 'fake-pdf', now()->addMinutes(30));

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.index'))
            ->post(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertRedirect(route('dealer.scan.index'));

        Queue::assertNothingPushed();
    });

    it('flashes a warning when a job is already running', function (): void {
        Cache::put(
            'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$this->store->id.'-executive',
            true,
            now()->addMinutes(5),
        );

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.index'))
            ->post(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertRedirect(route('dealer.scan.index'))
            ->assertSessionHas('flash.warning');

        Queue::assertNothingPushed();
    });

    it('rejects unknown report types', function (): void {
        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.index'))
            ->post(route('dealer.scan.queue-report'), ['type' => 'invalid'])
            ->assertSessionHasErrors('type');
    });
});

describe('POST scans/refresh-cache', function (): void {
    beforeEach(function (): void {
        $this->consultant->update(['current_store_id' => $this->store->id]);
    });

    it('clears the Cyrisma cache for the current store', function (): void {
        $service = test()->mock(CyrismaService::class);
        $service->shouldReceive('forStore')->andReturn($service);
        $service->shouldReceive('clearCache')->once();

        $this->actingAs($this->consultant)
            ->from(route('dealer.scan.index'))
            ->post(route('dealer.scan.refresh-cache'))
            ->assertRedirect(route('dealer.scan.index'))
            ->assertSessionHas('flash.success');
    });
});
