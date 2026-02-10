<?php

declare(strict_types=1);

use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealer\VendorForm;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    [$this->tenant, $this->consultant] = createDealershipTenant();
});

afterEach(function (): void {
    teardownTenants();
});

function createMailgunWebhookPayload(string $event, string $messageId, ?int $timestamp = null): array
{
    $timestamp ??= time();
    $token = bin2hex(random_bytes(25));

    return [
        'signature' => [
            'timestamp' => $timestamp,
            'token' => $token,
            'signature' => hash_hmac('sha256', $timestamp.$token, 'test-signing-key'),
        ],
        'event-data' => [
            'event' => $event,
            'message' => [
                'headers' => [
                    'message-id' => $messageId,
                ],
            ],
            'delivery-status' => [
                'message' => 'Test delivery message',
            ],
        ],
    ];
}

it('updates email log when delivery event is received', function (): void {
    $emailLog = null;

    $this->tenant->run(function () use (&$emailLog): void {
        $vendor = Vendor::query()->create([
            'name' => 'Test Vendor',
            'contact_name' => 'John Doe',
            'contact_email' => 'john@vendor.com',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $emailLog = VendorEmailLog::query()->create([
            'vendor_form_id' => $vendorForm->id,
            'to' => 'vendor@example.com',
            'subject' => 'Test Email',
            'message_id' => '<test-message-id@mailgun.net>',
            'sent_at' => now(),
            'status' => 'sent',
        ]);
    });

    $payload = createMailgunWebhookPayload('delivered', '<test-message-id@mailgun.net>');

    $response = $this->postJson('/api/webhooks/mailgun', $payload);

    $response->assertStatus(200);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        expect($emailLog->status)->toBe('delivered');
        expect($emailLog->delivered_at)->not->toBeNull();
        expect($emailLog->delivery_message)->toBe('Successfully delivered');
        expect($emailLog->event_type)->toBe('delivered');
    });
});

it('updates email log when failure event is received', function (): void {
    $emailLog = null;

    $this->tenant->run(function () use (&$emailLog): void {
        $vendor = Vendor::query()->create([
            'name' => 'Test Vendor',
            'contact_name' => 'Jane Doe',
            'contact_email' => 'jane@vendor.com',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $emailLog = VendorEmailLog::query()->create([
            'vendor_form_id' => $vendorForm->id,
            'to' => 'bounced@example.com',
            'subject' => 'Test Email',
            'message_id' => '<bounced-message-id@mailgun.net>',
            'sent_at' => now(),
            'status' => 'sent',
        ]);
    });

    $payload = createMailgunWebhookPayload('failed', '<bounced-message-id@mailgun.net>');

    $response = $this->postJson('/api/webhooks/mailgun', $payload);

    $response->assertStatus(200);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        expect($emailLog->status)->toBe('failed');
        expect($emailLog->delivered_at)->not->toBeNull();
        expect($emailLog->delivery_message)->toContain('Test delivery message');
        expect($emailLog->event_type)->toBe('failed');
    });
});

it('rejects webhook with invalid signature', function (): void {
    $emailLog = null;

    $this->tenant->run(function () use (&$emailLog): void {
        $vendor = Vendor::query()->create([
            'name' => 'Test Vendor',
            'contact_name' => 'Alice Cooper',
            'contact_email' => 'alice@vendor.com',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $emailLog = VendorEmailLog::query()->create([
            'vendor_form_id' => $vendorForm->id,
            'to' => 'vendor@example.com',
            'subject' => 'Test Email',
            'message_id' => '<test-invalid-sig@mailgun.net>',
            'sent_at' => now(),
            'status' => 'sent',
        ]);
    });

    $timestamp = time();
    $token = bin2hex(random_bytes(25));

    // Create invalid signature
    $invalidPayload = [
        'signature' => [
            'timestamp' => $timestamp,
            'token' => $token,
            'signature' => 'invalid-signature-hash',
        ],
        'event-data' => [
            'event' => 'delivered',
            'message' => [
                'headers' => [
                    'message-id' => '<test-invalid-sig@mailgun.net>',
                ],
            ],
        ],
    ];

    $response = $this->postJson('/api/webhooks/mailgun', $invalidPayload);

    $response->assertStatus(401);
    $response->assertJson(['error' => 'Unauthorized']);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        // Status should remain unchanged
        expect($emailLog->status)->toBe('sent');
    });
});

it('rejects webhook with expired timestamp', function (): void {
    $emailLog = null;

    $this->tenant->run(function () use (&$emailLog): void {
        $vendor = Vendor::query()->create([
            'name' => 'Test Vendor',
            'contact_name' => 'Charlie Brown',
            'contact_email' => 'charlie@vendor.com',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $emailLog = VendorEmailLog::query()->create([
            'vendor_form_id' => $vendorForm->id,
            'to' => 'vendor@example.com',
            'subject' => 'Test Email',
            'message_id' => '<test-expired@mailgun.net>',
            'sent_at' => now(),
            'status' => 'sent',
        ]);
    });

    // Timestamp from 20 minutes ago (expired)
    $expiredTimestamp = time() - 1200;

    $payload = createMailgunWebhookPayload('delivered', '<test-expired@mailgun.net>', $expiredTimestamp);

    $response = $this->postJson('/api/webhooks/mailgun', $payload);

    $response->assertStatus(401);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        // Status should remain unchanged
        expect($emailLog->status)->toBe('sent');
    });
});

it('returns 200 when email log is not found', function (): void {
    $payload = createMailgunWebhookPayload('delivered', '<non-existent-message-id@mailgun.net>');

    $response = $this->postJson('/api/webhooks/mailgun', $payload);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Email log not found']);
});

it('handles opened and clicked events without changing status', function (): void {
    $emailLog = null;

    $this->tenant->run(function () use (&$emailLog): void {
        $vendor = Vendor::query()->create([
            'name' => 'Test Vendor',
            'contact_name' => 'David Lee',
            'contact_email' => 'david@vendor.com',
        ]);

        $vendorForm = VendorForm::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
        ]);

        $emailLog = VendorEmailLog::query()->create([
            'vendor_form_id' => $vendorForm->id,
            'to' => 'vendor@example.com',
            'subject' => 'Test Email',
            'message_id' => '<test-opened@mailgun.net>',
            'sent_at' => now(),
            'status' => 'delivered',
        ]);
    });

    // Test opened event
    $payload = createMailgunWebhookPayload('opened', '<test-opened@mailgun.net>');
    $response = $this->postJson('/api/webhooks/mailgun', $payload);
    $response->assertStatus(200);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        // Status should remain delivered, but event_type should be updated
        expect($emailLog->status)->toBe('delivered');
        expect($emailLog->event_type)->toBe('opened');
    });

    // Test clicked event
    $payload = createMailgunWebhookPayload('clicked', '<test-opened@mailgun.net>');
    $response = $this->postJson('/api/webhooks/mailgun', $payload);
    $response->assertStatus(200);

    $this->tenant->run(function () use ($emailLog): void {
        $emailLog->refresh();

        expect($emailLog->status)->toBe('delivered');
        expect($emailLog->event_type)->toBe('clicked');
    });
});
