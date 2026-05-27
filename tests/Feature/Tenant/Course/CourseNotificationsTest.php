<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Dealer\Course as TenantCourse;
use App\Notifications\CourseExpiredNotification;
use App\Notifications\CourseExpiringSoonNotification;
use App\Notifications\DotCertificateReadyNotification;
use App\Notifications\ExpiredCourseNotification;
use App\Notifications\IncompleteCoursesNotification;
use Carbon\CarbonImmutable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;

describe('DotCertificateReadyNotification', function (): void {
    it('routes through the database channel only', function (): void {
        $channels = (new DotCertificateReadyNotification)->via(new AnonymousNotifiable);

        expect($channels)->toBe(['database']);
    });

    it('builds a payload with a profile link and success styling', function (): void {
        $payload = (new DotCertificateReadyNotification)->toArray(new AnonymousNotifiable);

        expect($payload['title'])->toBe('Certificate ready')
            ->and($payload['message'])->toContain('DOT Hazardous Materials Transportation')
            ->and($payload['level'])->toBe('success')
            ->and($payload['icon'])->toBe('Award');

        expect($payload['actions'])->toHaveCount(1);
        expect($payload['actions'][0]['url'])->toBe(route('dealer.profile.edit'));
    });
});

describe('CourseExpiredNotification', function (): void {
    it('routes through the mail channel and links to the course on the tenant domain', function (): void {
        $course = TenantCourse::query()->create([
            'slug' => 'expired-course',
            'name' => 'Expired Course',
            'slides' => [],
            'questions' => [],
        ]);

        $notification = new CourseExpiredNotification(
            tenantDomain: 'acme.test',
            userName: 'Pat',
            courseId: $course->id,
            expireDate: CarbonImmutable::parse('2026-04-01'),
        );

        expect($notification->via(new AnonymousNotifiable))->toBe(['mail']);

        $mail = $notification->toMail(new AnonymousNotifiable);

        expect($mail)->toBeInstanceOf(MailMessage::class)
            ->and($mail->actionUrl)->toBe('https://acme.test/courses/expired-course')
            ->and($mail->greeting)->toBe('Pat');

        $body = implode("\n", [...$mail->introLines, ...$mail->outroLines]);
        expect($body)->toContain('Expired Course')->toContain('April 01, 2026');
    });
});

describe('CourseExpiringSoonNotification', function (): void {
    it('routes through mail and includes the dealer course slug + expiry date', function (): void {
        $course = TenantCourse::query()->create([
            'slug' => 'expiring-course',
            'name' => 'Expiring Soon Course',
            'slides' => [],
            'questions' => [],
        ]);

        $notification = new CourseExpiringSoonNotification(
            tenantDomain: 'acme.test',
            userName: 'Sam',
            courseId: $course->id,
            expireDate: CarbonImmutable::parse('2026-08-15'),
        );

        expect($notification->via(new AnonymousNotifiable))->toBe(['mail']);

        $mail = $notification->toMail(new AnonymousNotifiable);

        expect($mail->actionUrl)->toBe('https://acme.test/courses/expiring-course')
            ->and($mail->greeting)->toBe('Sam');

        $body = implode("\n", [...$mail->introLines, ...$mail->outroLines]);
        expect($body)->toContain('Expiring Soon Course')->toContain('August 15, 2026');
    });
});

describe('ExpiredCourseNotification', function (): void {
    beforeEach(function (): void {
        // ExpiredCourseNotification looks up courses via the default connection
        // — in tenant context that's the tenant database, which carries a synced
        // courses table.
        $this->expiringCourse = Course::query()->create([
            'slug' => 'expiring-30-'.uniqid(),
            'name' => 'Expiring In 30',
            'slides' => [],
            'questions' => [],
        ]);
        $this->expiredTodayCourse = Course::query()->create([
            'slug' => 'expired-today-'.uniqid(),
            'name' => 'Expired Today',
            'slides' => [],
            'questions' => [],
        ]);
        $this->expired30Course = Course::query()->create([
            'slug' => 'expired-30-'.uniqid(),
            'name' => 'Expired 30 Days Ago',
            'slides' => [],
            'questions' => [],
        ]);
    });

    it('routes through both mail and database channels', function (): void {
        $notification = new ExpiredCourseNotification(
            coursesGrouped: ['expiring_soon' => []],
            userName: 'Anyone',
        );

        expect($notification->via(new AnonymousNotifiable))->toBe(['mail', 'database']);
    });

    it('lists every grouped course in the mail body with a section heading', function (): void {
        $notification = new ExpiredCourseNotification(
            coursesGrouped: [
                'expiring_soon' => [$this->expiringCourse->id],
                'expired_today' => [$this->expiredTodayCourse->id],
                'expired_30_days' => [$this->expired30Course->id],
            ],
            userName: 'Riley',
        );

        $mail = $notification->toMail(new AnonymousNotifiable);

        expect($mail->subject)->toBe('Course Expiration Reminder')
            ->and($mail->greeting)->toBe('Hello Riley,');

        $body = implode("\n", [...$mail->introLines, ...$mail->outroLines]);
        expect($body)
            ->toContain('expire in 30 days')->toContain('Expiring In 30')
            ->toContain('expire today')->toContain('Expired Today')
            ->toContain('expired 30 days ago')->toContain('Expired 30 Days Ago');
    });

    it('writes a single database row summarizing the counts per bucket', function (): void {
        $payload = (new ExpiredCourseNotification(
            coursesGrouped: [
                'expiring_soon' => [$this->expiringCourse->id, $this->expired30Course->id],
                'expired_today' => [$this->expiredTodayCourse->id],
                'expired_30_days' => [],
            ],
            userName: 'Riley',
        ))->toDatabase(new AnonymousNotifiable);

        expect($payload['message'])->toBe(
            'Course Reminder: 2 course(s) expiring in 30 days, 1 course(s) expired today'
        );
    });

    it('skips empty buckets from the mail and the database payload', function (): void {
        $notification = new ExpiredCourseNotification(
            coursesGrouped: [
                'expiring_soon' => [$this->expiringCourse->id],
                'expired_today' => [],
                'expired_30_days' => [],
            ],
            userName: 'Riley',
        );

        $body = implode("\n", [
            ...$notification->toMail(new AnonymousNotifiable)->introLines,
            ...$notification->toMail(new AnonymousNotifiable)->outroLines,
        ]);
        expect($body)->toContain('expire in 30 days')
            ->not->toContain('expire today')
            ->not->toContain('expired 30 days ago');

        $payload = $notification->toDatabase(new AnonymousNotifiable);
        expect($payload['message'])->toBe('Course Reminder: 1 course(s) expiring in 30 days');
    });
});

describe('IncompleteCoursesNotification', function (): void {
    it('routes through the mail channel only', function (): void {
        $channels = (new IncompleteCoursesNotification('Pat'))->via(new AnonymousNotifiable);

        expect($channels)->toBe(['mail']);
    });

    it('builds a reminder mail with the user name and a link to /courses', function (): void {
        $mail = (new IncompleteCoursesNotification('Pat'))->toMail(new AnonymousNotifiable);

        expect($mail->subject)->toBe('Reminder: You have incomplete courses')
            ->and($mail->greeting)->toBe('Hello Pat,')
            ->and($mail->actionText)->toBe('View Courses')
            ->and($mail->actionUrl)->toEndWith('/courses');

        $body = implode("\n", [...$mail->introLines, ...$mail->outroLines]);
        expect($body)->toContain('have not been started');
    });
});
