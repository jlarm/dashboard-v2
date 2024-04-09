<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ExpiredCourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $name;

    public function __construct($course)
    {
        $this->name = Course::where('id', $course)->first()->name;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'Course '.$this->name.' has expired.',
        ];
    }
}
