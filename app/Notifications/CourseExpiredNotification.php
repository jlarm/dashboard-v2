<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Dealer\Course;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class CourseExpiredNotification extends Notification
{
    public ?Course $course;
    public string $domain;
    public string $expireDate;

    public function __construct(string $tenantDomain, public string $userName, protected int $courseId, Carbon $expireDate)
    {
        $this->course = Course::query()->where('id', $this->courseId)->first();
        $this->domain = 'https://'.$tenantDomain.'/courses/'.$this->course->slug;
        $this->expireDate = $expireDate->format('F d, Y');
    }

    /**
     * @return array<int, string>
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->userName)
            ->line('The course '.$this->course->name.' expired on '.$this->expireDate.'. Click the link below to take the course.')
            ->action('Take the Course', url($this->domain));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(mixed $notifiable): array
    {
        return [];
    }
}
