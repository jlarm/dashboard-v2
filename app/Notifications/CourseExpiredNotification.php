<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Dealer\Course;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseExpiredNotification extends Notification
{
    public $course;
    public $domain;
    public $userName;
    public $expireDate;

    public function __construct($tenantDomain, $userName, protected int $courseId, $expireDate)
    {
        $this->course = Course::where('id', $this->courseId)->first();
        $this->domain = 'https://'.$tenantDomain.'/courses/'.$this->course->slug;
        $this->userName = $userName;
        $this->expireDate = $expireDate->format('F d, Y');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->userName)
            ->line('The course '.$this->course->name.' expired on '.$this->expireDate.'. Click the link below to take the course.')
            ->action('Take the Course', url($this->domain));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
