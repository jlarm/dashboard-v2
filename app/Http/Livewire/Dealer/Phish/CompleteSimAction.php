<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Store;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CompleteSimAction extends Component
{
    public PhishingCampaign $phishingCampaign;
    public $token;
    public $ip;

    public function mount()
    {
        $store = Store::first();
        $this->token = $store->phishing_token;
        $this->ip = $store->phishing_ip;
    }

    public function completeCampaign()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->get('https://'.$this->ip.':3333/api/campaigns/'.$this->phishingCampaign->campaign_id.'/complete');

            Notification::make()
                ->title('Campaign Completed Successfully!')
                ->success()
                ->send();

            if ($response->status() === 200) {
                $this->phishingCampaign->update([
                    'status' => 'Completed',
                ]);
            }

            return redirect()->route('dealer.phishing.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.dealer.phish.complete-sim-action');
    }
}
