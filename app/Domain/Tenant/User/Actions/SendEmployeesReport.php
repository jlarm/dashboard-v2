<?php

declare(strict_types=1);

namespace App\Domain\Tenant\User\Actions;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class SendEmployeesReport
{
    public function handle(string $toEmail, string $csvContent): void
    {
        $filename = 'incomplete-employee-courses-report-'.date('m-d-Y').'.csv';
        $body = 'Attached is an outline of the progress your employees have made regarding completing their compliance training courses. If an employee is not noted, they have completed all courses assigned. If you have further questions regarding this, you can always access your compliance dashboard and review your departments progress as a whole.';

        Mail::send([], [], function (Message $message) use ($toEmail, $csvContent, $body, $filename): void {
            $message->to($toEmail)
                ->from((string) config('mail.from.address'), (string) config('mail.from.name'))
                ->subject('Incomplete Employee Courses Report as of '.date('m/d/Y'))
                ->text($body)
                ->attachData($csvContent, $filename, ['mime' => 'text/csv']);
        });
    }
}
