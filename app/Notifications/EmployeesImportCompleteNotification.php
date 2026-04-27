<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Domain\Tenant\User\Data\ImportEmployeesResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeesImportCompleteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly ImportEmployeesResult $result) {}

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Employee import results');

        if ($this->result->errors !== []) {
            $message->error()
                ->line('Your employee import failed validation and was rolled back.')
                ->line(count($this->result->errors).' row(s) had errors:');

            foreach (array_slice($this->result->errors, 0, 10) as $error) {
                $message->line("Row {$error['row']}: ".implode('; ', $error['errors']));
            }

            if (count($this->result->errors) > 10) {
                $message->line('...and '.(count($this->result->errors) - 10).' more.');
            }

            return $message;
        }

        $message->line("{$this->result->successCount} invite(s) were imported successfully.");

        if ($this->result->skippedCount > 0) {
            $message->line("{$this->result->skippedCount} row(s) were skipped (already invited or registered).");
        }

        return $message;
    }
}
