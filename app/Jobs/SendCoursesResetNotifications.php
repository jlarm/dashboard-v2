<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\CourseResetNotificationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendCoursesResetNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Collection $userIds,
        public string $tenantName
    ) {}

    public function handle(): void
    {
        User::whereIn('id', $this->userIds)
            ->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(
                        new CourseResetNotificationMail(
                            userName: $user->name,
                            tenantName: $this->tenantName
                        )
                    );
                }
            });
    }
}
