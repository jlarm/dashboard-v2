<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExpiredCourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $coursesGrouped, public string $userName) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('Course Expiration Reminder')
            ->greeting('Hello '.$this->userName.',');

        // Add courses expiring in 30 days
        if (! empty($this->coursesGrouped['expiring_soon'])) {
            $mail->line('**The following courses will expire in 30 days:**');
            foreach ($this->coursesGrouped['expiring_soon'] as $courseId) {
                $courseName = Course::query()->find($courseId)->name ?? 'Unknown Course';
                $mail->line('• '.$courseName);
            }
            $mail->line('');
        }

        // Add courses expiring today
        if (! empty($this->coursesGrouped['expired_today'])) {
            $mail->line('**The following courses expire today:**');
            foreach ($this->coursesGrouped['expired_today'] as $courseId) {
                $courseName = Course::query()->find($courseId)->name ?? 'Unknown Course';
                $mail->line('• '.$courseName);
            }
            $mail->line('');
        }

        // Add courses expired 30 days ago
        if (! empty($this->coursesGrouped['expired_30_days'])) {
            $mail->line('**The following courses expired 30 days ago and need renewal:**');
            foreach ($this->coursesGrouped['expired_30_days'] as $courseId) {
                $courseName = Course::query()->find($courseId)->name ?? 'Unknown Course';
                $mail->line('• '.$courseName);
            }
            $mail->line('');
        }

        $mail->salutation('Please complete at your earliest convenience.');

        return $mail;
    }

    public function toDatabase($notifiable): array
    {
        $messages = [];

        if (! empty($this->coursesGrouped['expiring_soon'])) {
            $count = count($this->coursesGrouped['expiring_soon']);
            $messages[] = "{$count} course(s) expiring in 30 days";
        }

        if (! empty($this->coursesGrouped['expired_today'])) {
            $count = count($this->coursesGrouped['expired_today']);
            $messages[] = "{$count} course(s) expired today";
        }

        if (! empty($this->coursesGrouped['expired_30_days'])) {
            $count = count($this->coursesGrouped['expired_30_days']);
            $messages[] = "{$count} course(s) expired 30 days ago";
        }

        return [
            'message' => 'Course Reminder: '.implode(', ', $messages),
        ];
    }
}
