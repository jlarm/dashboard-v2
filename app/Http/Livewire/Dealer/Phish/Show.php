<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Timeline;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public PhishingCampaign $phishingCampaign;

    public $users;

    public function mount()
    {
        $timelines = Timeline::query()
            ->where('phishing_campaign_id', $this->phishingCampaign->id)
            ->with('user')
            ->get();

        $this->users = [];

        foreach ($timelines as $timeline) {
            if ($timeline->user) {
                $userEmail = $timeline->user->email;

                if (!isset($this->users[$userEmail])) {
                    $this->users[$userEmail] = [
                        'name' => $timeline->user->name,
                        'email' => $userEmail,
                        'timeline' => []
                    ];
                }

                $this->users[$userEmail]['timeline'][] = $timeline;
            }
        }
    }

    public function color()
    {
        return match ($this->phishingCampaign->status) {
            'In progress' => 'blue',
            'Completed' => 'green',
            'Queued' => 'yellow',
            'Error' => 'red',
            default => 'gray',
        };
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
                ->get('https://'.config('gophish.ip').':3333/api/campaigns/'.$this->phishingCampaign->campaign_id.'/complete');

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

    public function deleteCampaign()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => config('gophish.key'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->delete('https://'.config('gophish.ip').':3333/api/campaigns/'.$this->phishingCampaign->campaign_id);

            Notification::make()
                ->title('Campaign Deleted Successfully!')
                ->success()
                ->send();

            if ($response->status() === 200) {
                $this->phishingCampaign->delete();
            }

            return redirect()->route('dealer.phishing.index');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.phish.show')->layout('components.dealer-app');
    }
}
