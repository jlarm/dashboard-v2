<?php

declare(strict_types=1);

use App\Jobs\SendVendorEmailJob;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealer\VendorForm;
use App\Notifications\VendorFormNotification;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Mailer\Exception\TransportException;

beforeEach(function (): void {
    $this->vendor = Vendor::query()->create([
        'name' => 'Test Vendor',
        'contact_name' => 'John Doe',
        'contact_email' => 'john@vendor.com',
    ]);

    $this->vendorForm = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Test Vendor',
        'email' => 'vendor@example.com',
    ]);
});

it('locks duplicate dispatches per vendor form within the retry window', function (): void {
    $job = new SendVendorEmailJob($this->vendorForm);

    expect($job)->toBeInstanceOf(ShouldBeUnique::class);
    expect($job->uniqueId())->toBe((string) $this->vendorForm->id);
    expect($job->uniqueFor())->toBeGreaterThan(0);
});

it('records a failed vendor email log when the job fails', function (): void {
    expect(VendorEmailLog::query()->count())->toBe(0);

    $exception = new TransportException('Connection to "smtp.mailgun.org:587" has been closed unexpectedly.');

    new SendVendorEmailJob($this->vendorForm)->failed($exception);

    expect(VendorEmailLog::query()->count())->toBe(1);

    $log = VendorEmailLog::query()->first();

    expect($log->vendor_form_id)->toBe($this->vendorForm->id);
    expect($log->to)->toBe('vendor@example.com');
    expect($log->status)->toBe('failed');
    expect($log->delivery_message)->toContain('smtp.mailgun.org:587');
    expect($log->sent_at)->not->toBeNull();
});

it('skips sending when a successful email log already exists within the retry window', function (): void {
    Notification::fake();

    VendorEmailLog::query()->create([
        'vendor_form_id' => $this->vendorForm->id,
        'to' => 'vendor@example.com',
        'subject' => 'Vendor Form Notification',
        'message_id' => '<abc123@example.com>',
        'sent_at' => now()->subMinute(),
    ]);

    new SendVendorEmailJob($this->vendorForm)->handle();

    Notification::assertNothingSent();
});

it('still sends when prior log entry is older than the retry window', function (): void {
    Notification::fake();

    VendorEmailLog::query()->create([
        'vendor_form_id' => $this->vendorForm->id,
        'to' => 'vendor@example.com',
        'subject' => 'Vendor Form Notification',
        'message_id' => '<old123@example.com>',
        'sent_at' => now()->subHour(),
    ]);

    new SendVendorEmailJob($this->vendorForm)->handle();

    Notification::assertSentOnDemand(VendorFormNotification::class);
});
