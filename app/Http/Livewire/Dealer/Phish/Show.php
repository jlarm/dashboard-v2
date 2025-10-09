<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\PhishingCampaign;
use App\Models\Dealer\Timeline;
use Livewire\Component;

class Show extends Component
{
    public PhishingCampaign $phishingCampaign;
    public $users;
    private $token;
    private $ip;

    public function mount()
    {
        $store = GlobalSetting::first();
        $this->token = $store->phishing_token;
        $this->ip = $store->phishing_ip;

        $timelines = Timeline::query()
            ->where('phishing_campaign_id', $this->phishingCampaign->id)
            ->with('user')
            ->get();

        $this->users = [];

        foreach ($timelines as $timeline) {
            if ($timeline->user) {
                $userEmail = $timeline->user->email;

                if (! isset($this->users[$userEmail])) {
                    $this->users[$userEmail] = [
                        'name' => $timeline->user->name,
                        'email' => $userEmail,
                        'timeline' => [],
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

    public function render()
    {
        return view('livewire.dealer.phish.show')->layout('components.dealer-app');
    }
}
