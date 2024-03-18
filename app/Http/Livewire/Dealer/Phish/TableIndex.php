<?php

namespace App\Http\Livewire\Dealer\Phish;

use App\Enums\GoPhishCampaignStatus;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Log;

class TableIndex extends Component
{
    public $campaigns;
    public $error;
    public $readyToLoad = false;

    public function loadSims()
    {
        $this->readyToLoad = true;
    }

    public function campaigns()
    {
        try {
            $this->campaigns = Http::withoutVerifying()->get('https://'. config('gophish.ip') .':3333/api/campaigns/?api_key='. config('gophish.key') .'');
            $this->campaigns = $this->campaigns->json();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            Log::error($e->getMessage());
            $this->campaigns = [];
        }

        $this->campaigns = array_map(function($campaign) {
            return [
                'id' => $campaign['id'],
                'name' => $campaign['name'],
                'created_date' => $campaign['created_date'],
                'status' => $campaign['status'],
            ];
        }, $this->campaigns);
    }

    public function render()
    {
        return view('livewire.dealer.phish.table-index', [
            'campaigns' => $this->readyToLoad ? $this->campaigns() : []
        ]);
    }
}
