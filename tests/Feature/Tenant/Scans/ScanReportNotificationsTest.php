<?php

declare(strict_types=1);

use App\Notifications\Scans\ScanReportFailedNotification;
use App\Notifications\Scans\ScanReportReadyNotification;
use Illuminate\Notifications\AnonymousNotifiable;

describe('ScanReportReadyNotification', function (): void {
    it('routes through the database channel only', function (): void {
        $channels = (new ScanReportReadyNotification('executive', 'Acme Store'))->via(new AnonymousNotifiable);

        expect($channels)->toBe(['database']);
    });

    it('renders a success-level payload with a download action for the executive variant', function (): void {
        $payload = (new ScanReportReadyNotification('executive', 'Acme Store'))->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Executive Report Ready')
            ->and($payload['level'])->toBe('success')
            ->and($payload['icon'])->toBe('CheckCircle2')
            ->and($payload['message'])->toContain('Executive')
            ->and($payload['message'])->toContain('Acme Store');

        expect($payload['actions'])->toHaveCount(1);
        expect($payload['actions'][0]['label'])->toBe('Download Report');
        expect($payload['actions'][0]['url'])->toBe(route('dealer.scan.report', ['type' => 'executive']));
    });

    it('uses the technical label and download URL for the technical variant', function (): void {
        $payload = (new ScanReportReadyNotification('technical', 'Acme Store'))->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Technical Report Ready');
        expect($payload['actions'][0]['url'])->toBe(route('dealer.scan.report', ['type' => 'technical']));
    });
});

describe('ScanReportFailedNotification', function (): void {
    it('routes through the database channel only', function (): void {
        $channels = (new ScanReportFailedNotification('executive', 'Acme Store'))->via(new AnonymousNotifiable);

        expect($channels)->toBe(['database']);
    });

    it('renders an error-level payload referencing the report type and store', function (): void {
        $payload = (new ScanReportFailedNotification('technical', 'Acme Store'))->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Report Generation Failed')
            ->and($payload['level'])->toBe('error')
            ->and($payload['icon'])->toBe('AlertTriangle')
            ->and($payload['message'])->toContain('Technical')
            ->and($payload['message'])->toContain('Acme Store')
            ->and($payload['actions'])->toBe([]);
    });
});
