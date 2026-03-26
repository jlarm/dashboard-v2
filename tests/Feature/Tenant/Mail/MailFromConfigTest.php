<?php

declare(strict_types=1);

use App\Mail\ComplianceFormMail;
use App\Mail\CourseNotificationMail;
use App\Mail\CourseResetNotificationMail;
use App\Mail\InviteMail;
use App\Mail\RemediationReminderMail;
use App\Mail\TenDayOpenInviteReminderMail;
use App\Mail\TwentyDayOpenInviteReminderMail;
use App\Models\Dealer\Department;
use App\Models\Dealer\Invite;
use Illuminate\Support\Str;

it('uses mail from config for mailables with hardcoded from values removed', function (): void {
    config()->set('mail.from.address', 'config-from@example.test');
    config()->set('mail.from.name', 'Config Sender');

    $department = Department::query()->create([
        'name' => 'Mail Config Department '.uniqid(),
        'slug' => 'mail-config-department-'.uniqid(),
    ]);

    $invite = Invite::query()->create([
        'name' => 'Invite Mail Config User',
        'email' => 'invite-mail-config-user@test.com',
        'stores' => [],
        'department_id' => $department->id,
        'user_id' => $this->consultant->id,
        'roles' => ['Employee'],
        'invitation_token' => Str::random(32),
        'courses' => [],
    ]);

    $mailables = [
        new RemediationReminderMail('Glba', false, 'store-slug'),
        new CourseNotificationMail('https://test-tenant.localhost/courses/any'),
        new ComplianceFormMail('https://test-tenant.localhost/form', 'Test Store'),
        new CourseResetNotificationMail('Example User', 'Tenant Example'),
        new TenDayOpenInviteReminderMail($invite),
        new TwentyDayOpenInviteReminderMail($invite),
        new InviteMail($invite),
    ];

    foreach ($mailables as $mailable) {
        $mailable->assertFrom('config-from@example.test', 'Config Sender');
    }
});
