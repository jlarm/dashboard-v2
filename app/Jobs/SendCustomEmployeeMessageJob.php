<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Mail\CustomEmployeeMessageMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendCustomEmployeeMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $subject,
        public string $messageBody,
    ) {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new CustomEmployeeMessageMail(
            user: $this->user,
            emailSubject: $this->subject,
            messageBody: $this->messageBody,
        ));
    }

    public function failed(?Throwable $exception): void
    {
        report_if($exception instanceof Throwable, $exception);
    }
}
