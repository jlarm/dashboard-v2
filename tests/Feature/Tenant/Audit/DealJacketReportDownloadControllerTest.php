<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

beforeEach(function (): void {
    Storage::fake();
});

it('streams a report file from local storage with the pdf content type', function (): void {
    $fileName = 'report-'.uniqid().'.pdf';
    Storage::put('deal-jacket-reports/'.$fileName, 'pdf-bytes');

    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.deal-jacket-reports.download', $fileName))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/pdf')
        ->assertHeader('Content-Disposition', 'inline; filename="'.$fileName.'"');
});

it('returns 404 when the report file is missing', function (): void {
    $this->actingAs($this->consultant)
        ->get(route('dealer.audit.deal-jacket-reports.download', 'does-not-exist.pdf'))
        ->assertNotFound();
});

it('redirects guests to login', function (): void {
    tenancy()->end();
    $this->tenant->run(function (): void {
        $this->get(route('dealer.audit.deal-jacket-reports.download', 'anything.pdf'))
            ->assertRedirect(route('dealer.login'));
    });
});
