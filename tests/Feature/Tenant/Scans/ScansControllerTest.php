<?php

declare(strict_types=1);

use App\Domain\Tenant\Scans\Actions\QueueScanReport;
use App\Jobs\Scans\GenerateCyrismaReportJob;
use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use RuntimeException;

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
            ->postJson(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertOk()
            ->assertJson(['status' => 'queued']);

        Queue::assertPushed(GenerateCyrismaReportJob::class);
    });

    it('always queues a fresh job even when a previous PDF is still cached', function (): void {
        Cache::put(sprintf('cyrisma_report_pdf_v2_%d_executive', $this->store->id), 'fake-pdf', now()->addMinutes(30));

        $this->actingAs($this->consultant)
            ->postJson(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertOk()
            ->assertJson(['status' => 'queued']);

        Queue::assertPushed(GenerateCyrismaReportJob::class);
    });

    it('returns an already-running response when a job is already running', function (): void {
        Cache::put(
            'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$this->store->id.'-executive',
            true,
            now()->addMinutes(5),
        );

        $this->actingAs($this->consultant)
            ->postJson(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertOk()
            ->assertJson(['status' => 'already-running']);

        Queue::assertNothingPushed();
    });

    it('rejects unknown report types', function (): void {
        $this->actingAs($this->consultant)
            ->postJson(route('dealer.scan.queue-report'), ['type' => 'invalid'])
            ->assertStatus(422);
    });

    it('reports status pending when a job lock exists', function (): void {
        Cache::put(
            'laravel_unique_job:'.GenerateCyrismaReportJob::class.'-'.$this->store->id.'-executive',
            true,
            now()->addMinutes(5),
        );

        $this->actingAs($this->consultant)
            ->getJson(route('dealer.scan.report-status', ['type' => 'executive']))
            ->assertOk()
            ->assertJson(['status' => 'pending']);
    });

    it('reports status ready with a download URL when the PDF is cached', function (): void {
        Cache::put(sprintf('cyrisma_report_pdf_v2_%d_executive', $this->store->id), 'fake-pdf', now()->addMinutes(30));

        $this->actingAs($this->consultant)
            ->getJson(route('dealer.scan.report-status', ['type' => 'executive']))
            ->assertOk()
            ->assertJson([
                'status' => 'ready',
                'url' => route('dealer.scan.report', ['type' => 'executive']),
            ]);
    });

    it('reports status not-queued when there is no cached PDF or lock', function (): void {
        $this->actingAs($this->consultant)
            ->getJson(route('dealer.scan.report-status', ['type' => 'executive']))
            ->assertOk()
            ->assertJson(['status' => 'not-queued']);
    });

    it('returns a 500 error when the queue action throws', function (): void {
        test()->mock(QueueScanReport::class, function ($mock): void {
            $mock->shouldReceive('handle')->andThrow(new RuntimeException('redis offline'));
        });

        $this->actingAs($this->consultant)
            ->postJson(route('dealer.scan.queue-report'), ['type' => 'executive'])
            ->assertStatus(500)
            ->assertJson(['status' => 'error']);
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
            ->assertSessionHas('success');
    });
});
