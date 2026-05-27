<?php

declare(strict_types=1);

use App\Mail\CourseNotificationMail;
use App\Mail\CourseResetNotificationMail;

describe('CourseResetNotificationMail', function (): void {
    it('builds an envelope from the configured mail.from with a fixed subject', function (): void {
        $mail = new CourseResetNotificationMail(userName: 'Pat', tenantName: 'Acme Auto');

        $envelope = $mail->envelope();

        expect($envelope->subject)->toBe('Your Training Courses Have Been Reset');
        expect($envelope->from->address)->toBe((string) config('mail.from.address'));
        expect($envelope->from->name)->toBe((string) config('mail.from.name'));
    });

    it('renders the reset email view with the user + tenant names', function (): void {
        $rendered = (new CourseResetNotificationMail(userName: 'Pat', tenantName: 'Acme Auto'))->render();

        expect($rendered)->toContain('Pat')->toContain('Acme Auto');
    });
});

describe('CourseNotificationMail', function (): void {
    it('builds the harassment-course envelope with the configured from address', function (): void {
        $mail = new CourseNotificationMail(courseLink: 'https://acme.test/courses/harassment');

        $envelope = $mail->envelope();

        expect($envelope->subject)->toBe('Required Harassment Course Notification');
        expect($envelope->from->address)->toBe((string) config('mail.from.address'));
    });

    it('renders the notification view including the course link', function (): void {
        $rendered = (new CourseNotificationMail(courseLink: 'https://acme.test/courses/harassment-2026'))->render();

        expect($rendered)->toContain('https://acme.test/courses/harassment-2026');
    });
});
