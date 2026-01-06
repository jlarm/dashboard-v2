<?php

declare(strict_types=1);

use App\Jobs\IncompleteVendorNotificationJob;
use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

it('logs vendor notification emails to database', function () {
    // Don't fake mail - we want the actual MessageSent event to fire
    // Testing environment uses 'array' driver which stores emails in memory
    Mail::alwaysTo('test@example.com');

    // Create a Qualified Individual user (required by the notification)
    $qualifiedIndividual = User::create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

    $vendor = Vendor::create([
        'name' => 'Test Vendor',
        'contact_name' => 'John Doe',
        'contact_email' => 'john@vendor.com',
    ]);

    $vendorForm = VendorForm::create([
        'vendor_id' => $vendor->id,
        'name' => 'Test Vendor',
        'email' => 'vendor@example.com',
    ]);

    expect(VendorEmailLog::count())->toBe(0);

    // Dispatch the job synchronously
    IncompleteVendorNotificationJob::dispatchSync($vendorForm);

    // Check that the email log was created
    expect(VendorEmailLog::count())->toBe(1);

    $log = VendorEmailLog::first();

    expect($log->vendor_form_id)->toBe($vendorForm->id);
    expect($log->to)->not->toBeEmpty(); // Should have a recipient email
    expect($log->subject)->not->toBeNull();
    expect($log->sent_at)->not->toBeNull();
});

it('does not log non-vendor emails', function () {
    // Send a regular email that doesn't have the vendor notification header
    Mail::raw('Test email', function ($message) {
        $message->to('test@example.com')
            ->subject('Test Subject');
    });

    // No log should be created
    expect(VendorEmailLog::count())->toBe(0);
});

it('stores vendor form relationship correctly', function () {
    Mail::alwaysTo('test@example.com');

    $qualifiedIndividual = User::create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

    $vendor = Vendor::create([
        'name' => 'Test Vendor',
        'contact_name' => 'Jane Doe',
        'contact_email' => 'jane@vendor.com',
    ]);

    $vendorForm = VendorForm::create([
        'vendor_id' => $vendor->id,
        'name' => 'Test Vendor',
        'email' => 'vendor@example.com',
    ]);

    IncompleteVendorNotificationJob::dispatchSync($vendorForm);

    $log = VendorEmailLog::first();

    // Test the relationship
    expect($log->vendorForm->id)->toBe($vendorForm->id);
    expect($vendorForm->emailLogs->count())->toBe(1);
    expect($vendorForm->emailLogs->first()->id)->toBe($log->id);
});

it('logs multiple emails for the same vendor form', function () {
    Mail::alwaysTo('test@example.com');

    $qualifiedIndividual = User::create([
        'name' => 'Qualified Individual',
        'email' => 'qi@example.com',
        'password' => bcrypt('password'),
    ]);
    $qualifiedIndividual->assignRole('Qualified Individual');

    $vendor = Vendor::create([
        'name' => 'Test Vendor',
        'contact_name' => 'Bob Smith',
        'contact_email' => 'bob@vendor.com',
    ]);

    $vendorForm = VendorForm::create([
        'vendor_id' => $vendor->id,
        'name' => 'Test Vendor',
        'email' => 'vendor@example.com',
    ]);

    // Send multiple emails
    IncompleteVendorNotificationJob::dispatchSync($vendorForm);
    IncompleteVendorNotificationJob::dispatchSync($vendorForm);
    IncompleteVendorNotificationJob::dispatchSync($vendorForm);

    expect(VendorEmailLog::count())->toBe(3);
    expect($vendorForm->emailLogs->count())->toBe(3);

    // All logs should be for the same vendor form
    $vendorForm->emailLogs->each(function ($log) use ($vendorForm) {
        expect($log->vendor_form_id)->toBe($vendorForm->id);
    });
});
