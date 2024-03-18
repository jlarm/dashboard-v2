<?php

namespace App\Http\Livewire\Dealer\Phish;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Show extends Component
{
    public $campaignId;
    public $campaign;
    public $users = [];
    public $count;
    public $counts = [];
    public $sentCount;
    public $error;
    public function mount()
    {
        try {
            $this->campaign = Http::withoutVerifying()->get('https://'. config('gophish.ip') .':3333/api/campaigns/' . $this->campaignId . '/results/?api_key='. config('gophish.key') .'');

            $this->campaign = $this->campaign->json();

            foreach ($this->campaign["results"] as $user) {
                $this->users[] = $user;
                foreach ($this->campaign["timeline"] as $item) {
                    if ($item["email"] === $user["email"]) {
                        $this->users[count($this->users) - 1]["timeline"][] = [
                            "time" => $item["time"],
                            "message" => $item["message"],
                            "details" => $item["details"]
                        ];
                    }
                }
            }

            $this->sentCount = count($this->campaign['results']);

            $this->statCount();
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            \Log::error($e->getMessage());
            $this->campaign = [];
        }
    }

    public function statCount(): void
    {
        $openedCount = 0;
        $clickedCount = 0;
        $submittedCount = 0;
        $reportedCount = 0;

        foreach ($this->campaign['timeline'] as $emailStatistic) {
            if ($emailStatistic['message'] === 'Email Opened') {
                $openedCount++;
            }
            if ($emailStatistic['message'] === 'Clicked Link') {
                $clickedCount++;
            }
            if ($emailStatistic['message'] === 'Submitted Data') {
                $submittedCount++;
            }
            if ($emailStatistic['message'] === 'Email Reported') {
                $reportedCount++;
            }
        }

        $this->counts['opened'] = $openedCount;
        $this->counts['clicked'] = $clickedCount;
        $this->counts['submitted'] = $submittedCount;
        $this->counts['reported'] = $reportedCount;
    }

    public function render()
    {
        return view('livewire.dealer.phish.show')->layout('components.dealer-app');
    }
}
