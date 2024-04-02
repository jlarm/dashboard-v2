<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Models\Dealer\GlobalSetting;
use App\Models\Dealer\PhishingCampaign;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Form extends Component
{
    public $groups;

    public $emails;

    public $pages;

    public $profiles;

    public $name;

    public $date;

    public $group;

    public $template;

    public $page;

    public $smtp;

    public $error;

    public $token;

    public $ip;

    public function mount()
    {
        $store = GlobalSetting::first();
        $this->token = $store->phishing_token;
        $this->ip = $store->phishing_ip;

        try {
            $this->groups = Http::withoutVerifying()->get('https://'.$this->ip.':3333/api/groups/?api_key='.$this->token.'');
            $this->groups = $this->groups->json();

            $this->emails = Http::withoutVerifying()->get('https://'.$this->ip.':3333/api/templates/?api_key='.$this->token.'');
            $this->emails = $this->emails->json();

            $this->pages = Http::withoutVerifying()->get('https://'.$this->ip.':3333/api/pages/?api_key='.$this->token.'');
            $this->pages = $this->pages->json();

            $this->profiles = Http::withoutVerifying()->get('https://'.$this->ip.':3333/api/smtp/?api_key='.$this->token.'');
            $this->profiles = $this->profiles->json();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Log::error($e->getMessage());
            $this->groups = [];
            $this->emails = [];
            $this->pages = [];
            $this->profiles = [];
        }
    }

    public function create()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
                ->withoutVerifying()
                ->post('https://'.$this->ip.':3333/api/campaigns/', [
                    'name' => $this->name,
                    'template' => ['name' => $this->template],
                    'url' => 'http://'.$this->ip,
                    'page' => ['name' => $this->page],
                    'smtp' => ['name' => $this->smtp],
                    'launch_date' => ($this->date) ? $this->date.'T00:00:00+00:00' : null,
                    'send_by_date' => null,
                    'groups' => [['name' => $this->group]],
                ]);

            $campaign = $response->json();

            Log::info($campaign);

            if ($response->successful()) {
                $launched_at = Carbon::parse($campaign['launch_date']);
                $campaign_created_at = Carbon::parse($campaign['created_date']);

                PhishingCampaign::create([
                    'campaign_id' => $campaign['id'],
                    'user_id' => auth()->id(),
                    'name' => $campaign['name'],
                    'status' => $campaign['status'],
                    'results' => $campaign['results'],
                    'launched_at' => $launched_at->format('Y-m-d H:i:s'),
                    'campaign_created_at' => $campaign_created_at->format('Y-m-d H:i:s'),
                ]);
            }

            Notification::make()
                ->title('Simulation Created Successfully!')
                ->success()
                ->send();

            return redirect()->route('dealer.phishing.index');

        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Log::error($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dealer.phish.form');
    }
}
