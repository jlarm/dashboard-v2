<?php

declare(strict_types=1);

use App\Models\Dealer\Vendor;
use App\Models\Dealer\VendorForm;
use App\Models\User;
use App\Notifications\VendorFormNotification;
use App\Notifications\VendorSignedNotification;
use Illuminate\Notifications\AnonymousNotifiable;

beforeEach(function (): void {
    $this->vendor = Vendor::query()->create([
        'name' => 'Acme Supplies',
        'contact_name' => 'Sam Vendor',
        'contact_email' => 'sam@vendor.test',
    ]);

    $this->vendorForm = VendorForm::query()->create([
        'vendor_id' => $this->vendor->id,
        'name' => 'Acme Supplies',
        'email' => 'sam@vendor.test',
    ]);
});

describe('VendorFormNotification', function (): void {
    it('routes through the mail channel', function (): void {
        $channels = (new VendorFormNotification($this->vendorForm))->via(new AnonymousNotifiable);

        expect($channels)->toBe(['mail']);
    });

    it('generates a temporary signed URL for the public form pointing at the vendor form id and recipient', function (): void {
        $notification = new VendorFormNotification($this->vendorForm);

        $url = $notification->generateUrl('recipient@vendor.test');

        expect($url)
            ->toContain('vid='.$this->vendorForm->id)
            ->toContain('email='.urlencode('recipient@vendor.test'))
            ->toContain('signature=');
    });

    it('addresses the email to the vendor and surfaces the tenant name + Qualified Individual contact', function (): void {
        $qi = User::query()->create([
            'name' => 'Riley QI',
            'email' => 'riley-qi-'.uniqid().'@test-tenant.localhost',
            'password' => bcrypt('x'),
        ]);
        $qi->assignRole('Qualified Individual');

        $notifiable = new AnonymousNotifiable;
        $notifiable->route('mail', 'sam@vendor.test');

        $mail = (new VendorFormNotification($this->vendorForm))->toMail($notifiable);

        $body = implode("\n", [...$mail->introLines, ...$mail->outroLines]);

        expect($mail->greeting)->toContain('Acme Supplies')
            ->and($mail->actionText)->toBe('Click Here')
            ->and($mail->salutation)->toBe(tenant('name'));

        expect($body)->toContain('Riley QI')->toContain($qi->email);
    });

    it('exposes the canonical mail subject as a class constant', function (): void {
        expect(VendorFormNotification::SUBJECT)->toBe('Vendor Form Notification');
    });
});

describe('VendorSignedNotification', function (): void {
    it('routes through the database channel and stores a "signed the vendor form" message', function (): void {
        $notification = new VendorSignedNotification($this->vendorForm);

        expect($notification->via(new AnonymousNotifiable))->toBe(['database']);

        $payload = $notification->toDatabase(new AnonymousNotifiable);
        expect($payload['message'])->toContain('Acme Supplies')->toContain('signed the vendor form');
    });
});
