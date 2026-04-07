<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\Support\Facades\Cache;

beforeEach(function (): void {
    Cache::flush();
    $this->store = Store::query()->first();
    app()->instance('currentStore', $this->store->id);
});

function mockCyrismaConfigured(): void
{
    $cyrisma = test()->mock(CyrismaService::class);
    $cyrisma->shouldReceive('forStore')->andReturn($cyrisma);
    $cyrisma->shouldReceive('isConfigured')->andReturn(true);
    $cyrisma->shouldReceive('hasShortName')->andReturn(true);
}

function seedReportCache(Store $store, string $type): void
{
    $cacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $store->id, $type);
    Cache::put($cacheKey, '%PDF-1.4 fake content', now()->addMinutes(30));
}

describe('download', function (): void {
    it('returns 404 for an invalid report type', function (): void {
        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'invalid']))
            ->assertNotFound();
    });

    it('returns 404 when the store cannot be found', function (): void {
        app()->instance('currentStore', 99999);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertNotFound();
    });

    it('returns 404 when cyrisma is not configured', function (): void {
        $cyrisma = $this->mock(CyrismaService::class);
        $cyrisma->shouldReceive('forStore')->andReturn($cyrisma);
        $cyrisma->shouldReceive('isConfigured')->andReturn(false);
        $cyrisma->shouldReceive('hasShortName')->andReturn(false);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertNotFound();
    });

    it('returns 404 when the store has no cyrisma short name configured', function (): void {
        $cyrisma = $this->mock(CyrismaService::class);
        $cyrisma->shouldReceive('forStore')->andReturn($cyrisma);
        $cyrisma->shouldReceive('isConfigured')->andReturn(true);
        $cyrisma->shouldReceive('hasShortName')->andReturn(false);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertNotFound();
    });

    it('returns 404 when the report has not been generated yet', function (): void {
        mockCyrismaConfigured();

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertNotFound();
    });

    it('streams the executive report from cache with pdf content type', function (): void {
        mockCyrismaConfigured();
        seedReportCache($this->store, 'executive');

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    });

    it('streams the technical report from cache with pdf content type', function (): void {
        mockCyrismaConfigured();
        seedReportCache($this->store, 'technical');

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'technical']))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    });

    it('includes the report type and store name in the content disposition filename', function (): void {
        mockCyrismaConfigured();
        seedReportCache($this->store, 'executive');

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']));

        $response->assertOk();

        $disposition = $response->headers->get('Content-Disposition');
        expect($disposition)
            ->toContain('executive')
            ->toContain('Test-Store');
    });

    it('sets private cache headers on the response', function (): void {
        mockCyrismaConfigured();
        seedReportCache($this->store, 'executive');

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']));

        $response->assertOk();
        expect($response->headers->get('Cache-Control'))->toContain('private');
    });
});
