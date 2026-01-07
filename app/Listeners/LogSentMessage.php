<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Dealer\VendorEmailLog;
use Illuminate\Mail\Events\MessageSent;

class LogSentMessage
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $headers = $message->getHeaders();

        // Only log vendor notification emails
        if (! $headers->has('X-Vendor-Notification')) {
            return;
        }

        // Extract 'to' addresses - handle both array format and Symfony Address objects
        $toAddresses = $message->getTo();
        $toEmails = '';
        if (is_array($toAddresses) && count($toAddresses) > 0) {
            $emails = [];
            foreach ($toAddresses as $address) {
                if (is_object($address) && method_exists($address, 'getAddress')) {
                    $emails[] = $address->getAddress();
                } elseif (is_string($address)) {
                    $emails[] = $address;
                }
            }
            $toEmails = implode(', ', $emails);
        } elseif (! is_array($toAddresses) && $toAddresses) {
            // Fallback for other formats
            $toEmails = implode(', ', array_keys((array) $toAddresses));
        }

        $data = [
            'vendor_form_id' => (int) $headers->get('X-Vendor-ID')?->getBodyAsString(),
            'to' => $toEmails ?: 'unknown',
            'subject' => (string) ($message->getSubject() ?? ''),
            'sent_at' => now()->toDateTimeString(),
        ];

        // If using Mailgun, the response data is available in $event->data
        // Only process if we have actual Mailgun response data (not the message object)
        if (isset($event->data) && is_array($event->data) && isset($event->data['id']) && is_string($event->data['id'])) {
            $data['mailgun_id'] = $event->data['id'];
            $data['mailgun_message'] = isset($event->data['message']) && is_string($event->data['message'])
                ? $event->data['message']
                : null;

            // Use Mailgun's ID as the message_id for webhook matching
            $data['message_id'] = $event->data['id'];
        }

        // Fallback: Try to get message ID from headers if Mailgun data not available
        if (empty($data['message_id']) && $headers->has('Message-ID')) {
            $messageIdHeader = $headers->get('Message-ID');
            if ($messageIdHeader && method_exists($messageIdHeader, 'getBodyAsString')) {
                $data['message_id'] = (string) $messageIdHeader->getBodyAsString();
            }
        }

        // Log if message_id is missing for debugging
        if (empty($data['message_id'])) {
            \Illuminate\Support\Facades\Log::warning('Vendor notification sent without message_id', [
                'vendor_form_id' => $data['vendor_form_id'],
                'to' => $data['to'],
                'has_message_id_header' => $headers->has('Message-ID'),
                'mailgun_data_available' => isset($event->data),
            ]);
        }

        VendorEmailLog::create($data);
    }
}
