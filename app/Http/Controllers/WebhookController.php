<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Timeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function gophish(Request $request): JsonResponse
    {
        $campaign = PhishingCampaign::query()->where('campaign_id', $request->input('campaign_id'))->first();
        abort_unless($campaign instanceof PhishingCampaign, 404);

        $message = (string) $request->input('message');

        Timeline::query()->create([
            'phishing_campaign_id' => $campaign->id,
            'email' => $request->input('email'),
            'time' => $request->input('time'),
            'message' => $message,
            'details' => $request->input('details'),
        ]);

        match ($message) {
            'Email Sent' => $campaign->increment('emails_sent'),
            'Email Opened' => $campaign->increment('emails_opened'),
            'Clicked Link' => $campaign->increment('links_clicked'),
            'Submitted Data' => $campaign->increment('data_submitted'),
            'Email Reported' => $campaign->increment('emails_reported'),
            default => null,
        };

        return response()->json(['status' => 'success']);
    }
}
