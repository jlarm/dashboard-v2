<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Dealer\VendorEmailLog;
use App\Models\VendorEmailLogIndex;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Str;

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

        $vendorFormId = $headers->get('X-Vendor-ID')?->getBodyAsString();

        if (empty($vendorFormId)) {
            return;
        }

        $data = [
            'vendor_form_id' => (int) $vendorFormId,
            'to' => $toEmails ?: 'unknown',
            'subject' => (string) ($message->getSubject() ?? ''),
            'sent_at' => now()->toDateTimeString(),
        ];

        // Try to get the Message-ID from the Symfony message
        // The Message-ID is set by the mail transport and should be available
        $messageId = null;

        // Method 1: Try to get from headers
        if ($headers->has('Message-ID')) {
            $messageIdHeader = $headers->get('Message-ID');
            if ($messageIdHeader && method_exists($messageIdHeader, 'getBodyAsString')) {
                $messageId = $messageIdHeader->getBodyAsString();
            }
        }

        // Method 2: Try getId() method on the message
        if (empty($messageId) && method_exists($message, 'getId')) {
            $messageId = $message->getId();
        }

        if (empty($messageId)) {
            $domain = config('mail.from.address') ? explode('@', config('mail.from.address'))[1] : 'local';
            $messageId = sprintf('<%s@%s>', Str::uuid(), $domain);
        }

        $data['message_id'] = $messageId;

        VendorEmailLog::create($data);

        $tenantId = tenant('id');
        if ($tenantId) {
            $normalizedMessageId = trim($messageId, '<>');
            tenancy()->central(function () use ($tenantId, $normalizedMessageId): void {
                VendorEmailLogIndex::updateOrCreate(
                    ['message_id' => $normalizedMessageId],
                    ['tenant_id' => $tenantId]
                );
            });
        }
    }
}
