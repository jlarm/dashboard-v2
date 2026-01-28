<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\PhishingCampaign;
use Exception;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DeleteSimAction extends Component
{
    public PhishingCampaign $phishingCampaign;
    public $token;
    public $ip;

    public function mount()
    {
        $store = GlobalSetting::first();
        $this->token = $store->phishing_token;
        $this->ip = $store->phishing_ip;
    }

    public function deleteCampaign()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->delete('https://'.$this->ip.':3333/api/campaigns/'.$this->phishingCampaign->campaign_id);

            Notification::make()
                ->title('Campaign Deleted Successfully!')
                ->success()
                ->send();

            if ($response->status() === 200) {
                $this->phishingCampaign->delete();
            }

            return redirect()->route('dealer.phishing.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.phish.delete-sim-action');
    }
}
