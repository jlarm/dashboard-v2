<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dealer\VendorEmailLog;
use App\Models\Dealership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MailgunWebhookController extends Controller
{
    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        // Verify the webhook is from Mailgun
        if (! $this->verifyWebhook($request)) {
            Log::warning('Mailgun webhook verification failed', [
                'ip' => $request->ip(),
            ]);

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $eventData = $request->input('event-data', []);
        $event = $eventData['event'] ?? null;
        $messageId = $eventData['message']['headers']['message-id'] ?? null;

        if (! $event || ! $messageId) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Search across all tenants for the email log
        $emailLog = null;
        $foundTenant = null;

        foreach (Dealership::cursor() as $tenant) {
            $tenant->run(function () use ($messageId, &$emailLog) {
                $emailLog = VendorEmailLog::where('message_id', $messageId)->first();
            });

            if ($emailLog) {
                $foundTenant = $tenant;
                break;
            }
        }

        if (! $emailLog || ! $foundTenant) {
            // Log not found - might not be a vendor email
            return response()->json(['message' => 'Email log not found'], 200);
        }

        // Update the log within the tenant context
        $foundTenant->run(function () use ($emailLog, $event, $eventData) {
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
            return false;
        }

        // Verify timestamp is recent (within 15 minutes)
        if (abs(time() - $timestamp) > 900) {
            return false;
        }

        // Verify signature
        $signingKey = config('services.mailgun.webhook_signing_key');

        if (! $signingKey) {
            Log::warning('Mailgun webhook signing key not configured');

            return false;
        }

        $expectedSignature = hash_hmac('sha256', $timestamp.$token, $signingKey);

        return hash_equals($expectedSignature, $signature);
    }
}
