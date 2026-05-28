<?php

declare(strict_types=1);

use App\Jobs\IncompleteVendorNotificationJob;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('logs vendor notification emails to database', function (): void {
    // Don't fake mail - we want the actual MessageSent event to fire
    // Testing environment uses 'array' driver which stores emails in memory
    Mail::alwaysTo('test@example.com');

    // Create a Qualified Individual user (required by the notification)
    $qualifiedIndividual = User::query()->create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

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

    expect(VendorEmailLog::query()->count())->toBe(0);

    // Dispatch the job synchronously
    dispatch_sync(new IncompleteVendorNotificationJob($vendorForm));

    // Check that the email log was created
    expect(VendorEmailLog::query()->count())->toBe(1);

    $log = VendorEmailLog::query()->first();

    expect($log->vendor_form_id)->toBe($vendorForm->id);
    expect($log->to)->not->toBeEmpty(); // Should have a recipient email
    expect($log->subject)->not->toBeNull();
    expect($log->sent_at)->not->toBeNull();
});

it('does not log non-vendor emails', function (): void {
    // Send a regular email that doesn't have the vendor notification header
    Mail::raw('Test email', function ($message): void {
        $message->to('test@example.com')
            ->subject('Test Subject');
    });

    // No log should be created
    expect(VendorEmailLog::query()->count())->toBe(0);
});

it('stores vendor form relationship correctly', function (): void {
    Mail::alwaysTo('test@example.com');

    $qualifiedIndividual = User::query()->create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

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

    dispatch_sync(new IncompleteVendorNotificationJob($vendorForm));

    $log = VendorEmailLog::query()->first();

    // Test the relationship
    expect($log->vendorForm->id)->toBe($vendorForm->id);
    expect($vendorForm->emailLogs->count())->toBe(1);
    expect($vendorForm->emailLogs->first()->id)->toBe($log->id);
});

it('logs multiple emails for the same vendor form', function (): void {
    Mail::alwaysTo('test@example.com');

    $qualifiedIndividual = User::query()->create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

    $vendor = Vendor::query()->create([
        'name' => 'Test Vendor',
        'contact_name' => 'Bob Smith',
        'contact_email' => 'bob@vendor.com',
    ]);

    $vendorForm = VendorForm::query()->create([
        'vendor_id' => $vendor->id,
        'name' => 'Test Vendor',
        'email' => 'vendor@example.com',
    ]);

    // The job dedupes sends within a 10-minute window via VendorEmailLog,
    // so travel past the window between dispatches to record three logs.
    Illuminate\Support\Facades\Date::setTestNow(now());
    dispatch_sync(new IncompleteVendorNotificationJob($vendorForm));

    Illuminate\Support\Facades\Date::setTestNow(now()->addMinutes(15));
    dispatch_sync(new IncompleteVendorNotificationJob($vendorForm));

    Illuminate\Support\Facades\Date::setTestNow(now()->addMinutes(15));
    dispatch_sync(new IncompleteVendorNotificationJob($vendorForm));

    Illuminate\Support\Facades\Date::setTestNow();

    expect(VendorEmailLog::query()->count())->toBe(3);
    expect($vendorForm->emailLogs->count())->toBe(3);

    // All logs should be for the same vendor form
    $vendorForm->emailLogs->each(function ($log) use ($vendorForm): void {
        expect($log->vendor_form_id)->toBe($vendorForm->id);
    });
});
