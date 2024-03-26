<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Timeline;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Show extends Component
{
    public $campaign_id;

    public $campaign;
    public $users;

    public function mount()
    {
        $this->campaign = PhishingCampaign::where('campaign_id', $this->campaign_id)->with('timelines.user')->first();

        $t = Timeline::query()
            ->where('campaign_id', $this->campaign_id)
            ->with('user')
            ->get();

        $this->users = $t->groupBy('user.name')->toBase();
    }


    public function completeCampaign()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->get('https://'.config('gophish.ip').':3333/api/campaigns/'.$this->campaign_id.'/complete');

            Notification::make()
                ->title('Campaign Completed Successfully!')
                ->success()
                ->send();

            return redirect()->route('dealer.phishing.index');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function deleteCampaign()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->delete('https://'.config('gophish.ip').':3333/api/campaigns/'.$this->campaign_id);

            Notification::make()
                ->title('Campaign Deleted Successfully!')
                ->success()
                ->send();

            return redirect()->route('dealer.phishing.index');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.phish.show')->layout('components.dealer-app');
    }
}
