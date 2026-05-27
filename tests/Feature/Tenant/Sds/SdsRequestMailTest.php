<?php

declare(strict_types=1);

use App\Mail\Tenant\SdsRequestMail;

it('uses the configured mail.from address and embeds the tenant name in the subject', function (): void {
    $mail = new SdsRequestMail(
        chemicalName: 'Acetone',
        manufacturer: 'Brand X',
        requesterName: 'Pat Tester',
        requesterEmail: 'pat@test-tenant.localhost',
        tenantName: 'Acme Auto',
    );

    $envelope = $mail->envelope();
    expect($envelope->subject)->toBe('New SDS Sheet Request - Acme Auto');
});

it('renders a body that includes the chemical, manufacturer, requester name, and requester email', function (): void {
    $rendered = (new SdsRequestMail(
        chemicalName: 'Acetone',
        manufacturer: 'Brand X',
        requesterName: 'Pat Tester',
        requesterEmail: 'pat@test-tenant.localhost',
        tenantName: 'Acme Auto',
    ))->render();

    expect($rendered)
        ->toContain('Acetone')
        ->toContain('Brand X')
        ->toContain('Pat Tester')
        ->toContain('pat@test-tenant.localhost');
});

it('renders without a manufacturer label when none is supplied', function (): void {
    $rendered = (new SdsRequestMail(
        chemicalName: 'Acetone',
        manufacturer: null,
        requesterName: 'Pat Tester',
        requesterEmail: 'pat@test-tenant.localhost',
        tenantName: 'Acme Auto',
    ))->render();

    expect($rendered)->toContain('Acetone')->toContain('Pat Tester');
});
