<?php

namespace App\Http\Controllers;

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Timeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stancl\Tenancy\Contracts\TenantDatabaseManager;

class WebhookController extends Controller
{
    public function gophish(Request $request): JsonResponse
    {
        Timeline::create([
            'campaign_id' => $request->input('campaign_id'),
            'email' => $request->input('email'),
            'time' => $request->input('time'),
            'message' => $request->input('message'),
            'details' => $request->input('details'),
        ]);

        $campaign = PhishingCampaign::where('campaign_id', $request->input('campaign_id'))->first();

        match ($request->input('message')) {
            'Email Opened' => $campaign->increment('emails_opened'),
            'Clicked Link' => $campaign->increment('links_clicked'),
            'Submitted Data' => $campaign->increment('data_submitted'),
            'Email Reported' => $campaign->increment('emails_reported'),
        };

        return response()->json(['status' => 'success']);
    }
}
