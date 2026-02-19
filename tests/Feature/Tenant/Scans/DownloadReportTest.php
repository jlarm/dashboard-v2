<?php

declare(strict_types=1);

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

beforeEach(function (): void {
    Cache::flush();
    $this->store = Store::query()->first();
    app()->instance('currentStore', $this->store->id);
});

function mockCyrismaReportService(): void
{
    $cyrisma = test()->mock(CyrismaService::class);
    $cyrisma->shouldReceive('forStore')->andReturn($cyrisma);
    $cyrisma->shouldReceive('isConfigured')->andReturn(true);
    $cyrisma->shouldReceive('hasShortName')->andReturn(true);
    $cyrisma->shouldReceive('getOverallDashboard')->andReturn([]);
    $cyrisma->shouldReceive('getVulnerabilityScans')->andReturn(['vulnerability_scans' => []]);
    $cyrisma->shouldReceive('getExternalIpScanData')->andReturn(['assets' => [], 'scan_info' => []]);
    $cyrisma->shouldReceive('getVulnerabilitiesByAssetType')->andReturn(['vulnerabilities' => []]);
    $cyrisma->shouldReceive('getCveDetails')->andReturn(['cve_items' => []]);
    $cyrisma->shouldReceive('getOpenPortsByAssetType')->andReturn([]);
}

function mockPdfFacade(): void
{
    $pdfInstance = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
    $pdfInstance->shouldReceive('setPaper')->with('letter')->andReturnSelf();
    $pdfInstance->shouldReceive('output')->andReturn('%PDF-1.4 fake content');

    Pdf::shouldReceive('loadView')->andReturn($pdfInstance);
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

    it('streams the executive report with pdf content type', function (): void {
        mockCyrismaReportService();
        mockPdfFacade();

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    });

    it('streams the technical report with pdf content type', function (): void {
        mockCyrismaReportService();
        mockPdfFacade();

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'technical']))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    });

    it('includes the report type and store name in the content disposition filename', function (): void {
        mockCyrismaReportService();
        mockPdfFacade();

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']));

        $response->assertOk();

        $disposition = $response->headers->get('Content-Disposition');
        expect($disposition)
            ->toContain('executive')
            ->toContain('Test-Store');
    });

    it('uses the executive blade view when generating the executive report', function (): void {
        mockCyrismaReportService();

        $pdfInstance = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
        $pdfInstance->shouldReceive('setPaper')->andReturnSelf();
        $pdfInstance->shouldReceive('output')->andReturn('%PDF-1.4');

        Pdf::shouldReceive('loadView')
            ->with('tenant.scans.reports.executive', Mockery::type('array'))
            ->once()
            ->andReturn($pdfInstance);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertOk();
    });

    it('uses the technical blade view when generating the technical report', function (): void {
        mockCyrismaReportService();

        $pdfInstance = Mockery::mock(\Barryvdh\DomPDF\PDF::class);
        $pdfInstance->shouldReceive('setPaper')->andReturnSelf();
        $pdfInstance->shouldReceive('output')->andReturn('%PDF-1.4');

        Pdf::shouldReceive('loadView')
            ->with('tenant.scans.reports.technical', Mockery::type('array'))
            ->once()
            ->andReturn($pdfInstance);

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'technical']))
            ->assertOk();
    });

    it('sets private cache headers by default', function (): void {
        mockCyrismaReportService();
        mockPdfFacade();

        $response = $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']));

        $response->assertOk();
        expect($response->headers->get('Cache-Control'))->toContain('private');
    });

    it('sets no-cache headers when the refresh query param is present', function (): void {
        mockCyrismaReportService();
        mockPdfFacade();

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']).'?refresh=1')
            ->assertOk()
            ->assertHeader('Pragma', 'no-cache');
    });

    it('returns a 500 response when pdf generation throws an exception', function (): void {
        mockCyrismaReportService();

        Pdf::shouldReceive('loadView')->andThrow(new RuntimeException('PDF render error'));

        $this->actingAs($this->consultant)
            ->get(route('dealer.scan.report', ['type' => 'executive']))
            ->assertStatus(500);
    });
});
