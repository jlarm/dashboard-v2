<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealership;
use App\Models\VendorEmailLogIndex;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MailgunWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        Log::info('Mailgun webhook received', [
            'ip' => $request->ip(),
            'event' => $request->input('event-data.event'),
        ]);

        // Verify the webhook is from Mailgun
        if (! $this->verifyWebhook($request)) {
            Log::warning('Mailgun webhook verification failed', [
                'ip' => $request->ip(),
                'has_signature' => $request->has('signature'),
            ]);

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $eventData = $request->input('event-data', []);
        $event = $eventData['event'] ?? null;
        $messageId = $eventData['message']['headers']['message-id'] ?? null;

        Log::info('Mailgun webhook verified', [
            'event' => $event,
            'message_id' => $messageId,
        ]);

        if (! $event || ! $messageId) {
            Log::warning('Mailgun webhook missing required data', [
                'event' => $event,
                'message_id' => $messageId,
            ]);

            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Search across all tenants for the email log
        $emailLog = null;
        $foundTenant = null;

        $normalizedMessageId = $this->normalizeMessageId($messageId);

        // Normalize message_id - try both with and without angle brackets
        $messageIdVariants = [
            $normalizedMessageId,
            '<'.$normalizedMessageId.'>',
        ];

        $index = tenancy()->central(fn () => VendorEmailLogIndex::query()->where('message_id', $normalizedMessageId)->first());
        if ($index) {
            $foundTenant = Dealership::query()->find($index->tenant_id);
            if ($foundTenant) {
                $foundTenant->run(function () use ($messageIdVariants, &$emailLog): void {
                    $emailLog = VendorEmailLog::query()->whereIn('message_id', $messageIdVariants)->first();
                });
            }
        }
        Log::warning('Mailgun webhook — index miss, falling back to full tenant scan', [
            'message_id' => $messageId,
            'event' => $event,
        ]);
        foreach (Dealership::query()->with('domains')->lazy() as $tenant) {
            $tenant->run(function () use ($messageIdVariants, &$emailLog): void {
                $emailLog = VendorEmailLog::query()->whereIn('message_id', $messageIdVariants)->first();
            });

            if ($emailLog instanceof VendorEmailLog) {
                $foundTenant = $tenant;
                break;
            }
        }
        if ($emailLog && $foundTenant) {
            tenancy()->central(function () use ($normalizedMessageId, $foundTenant): void {
                VendorEmailLogIndex::query()->updateOrCreate(['message_id' => $normalizedMessageId], ['tenant_id' => $foundTenant->id]);
            });
        }

        if (! $emailLog || ! $foundTenant) {
            Log::debug('Mailgun webhook - email log not found', [
                'message_id' => $messageId,
                'event' => $event,
            ]);

            return response()->json(['message' => 'Email log not found'], 200);
        }

        Log::info('Mailgun webhook - email log found', [
            'email_log_id' => $emailLog->id,
            'tenant_id' => $foundTenant->id,
            'event' => $event,
        ]);

        // Update the log within the tenant context
        $foundTenant->run(function () use ($emailLog, $event, $eventData): void {
            $this->updateEmailLog($emailLog, $event, $eventData);
        });

        return response()->json(['message' => 'Webhook processed'], 200);
    }

    protected function updateEmailLog(VendorEmailLog $emailLog, string $event, array $eventData): void
    {
        $updates = [
            'event_type' => $event,
        ];

        switch ($event) {
            case 'delivered':
                $updates['status'] = 'delivered';
                $updates['delivered_at'] = now();
                $updates['delivery_message'] = 'Successfully delivered';
                break;

            case 'failed':
                $updates['status'] = 'failed';
                $updates['delivered_at'] = now();
                $updates['delivery_message'] = $eventData['delivery-status']['message'] ?? 'Delivery failed';
                break;

            case 'complained':
                $updates['status'] = 'complained';
                $updates['delivery_message'] = 'Marked as spam';
                break;

            case 'unsubscribed':
                $updates['status'] = 'unsubscribed';
                $updates['delivery_message'] = 'Recipient unsubscribed';
                break;

            case 'opened':
                // Don't change status, just log the event
                $updates['event_type'] = 'opened';
                break;

            case 'clicked':
                // Don't change status, just log the event
                $updates['event_type'] = 'clicked';
                break;
        }

        $emailLog->update($updates);

        Log::info('Mailgun webhook processed', [
            'email_log_id' => $emailLog->id,
            'event' => $event,
            'status' => $updates['status'] ?? $emailLog->status,
        ]);
    }

    protected function verifyWebhook(Request $request): bool
    {
        // Mailgun webhook verification
        $token = $request->input('signature.token');
        $timestamp = $request->input('signature.timestamp');
        $signature = $request->input('signature.signature');

        // Check if signature data exists
        if (! $token || ! $timestamp || ! $signature) {
            Log::warning('Mailgun webhook missing signature data', [
                'has_token' => ! empty($token),
                'has_timestamp' => ! empty($timestamp),
                'has_signature' => ! empty($signature),
            ]);

            return false;
        }

        // Verify timestamp is recent (within 15 minutes)
        if (abs(time() - $timestamp) > 900) {
            Log::warning('Mailgun webhook timestamp expired', [
                'timestamp' => $timestamp,
                'current_time' => time(),
                'age_seconds' => abs(time() - $timestamp),
            ]);

            return false;
        }

        // Verify signature
        $signingKey = config('services.mailgun.webhook_signing_key');

        if (! $signingKey) {
            Log::warning('Mailgun webhook signing key not configured');

            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp.$token, (string) $signingKey);

        if (! hash_equals($expectedSignature, $signature)) {
            Log::warning('Mailgun webhook signature mismatch');

            return false;
        }

        return true;
    }

    private function normalizeMessageId(string $messageId): string
    {
        return mb_trim($messageId, '<>');
    }
}
