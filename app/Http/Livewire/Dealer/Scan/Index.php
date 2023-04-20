<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanSetting;
use Cookie;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use Response;

class   Index extends Component
{
    public string $type = 'technical';
    public string $dealer;
    public $assets;

    public function mount()
    {
        $statToken = Cookie::get('sentry');
        $statClient = new Client();
        $statNames = ['live_assets', 'root_domains', 'subdomains'];
        $this->dealer = ScanSetting::first()->name ?? '';

        $statRequest = new Request('GET', 'https://blue-api.redsentry.com/external/stats/total/live_assets?sentry=Victor%20Ford', [
            'Authorization' => $statToken,
        ]);

        $send = $statClient->send($statRequest)->getBody()->getContents();

        $this->assets = json_decode($send);

        $this->assets = $this->assets->total;
    }

    public function export()
    {
        $token = Cookie::get('sentry');
        $client = new Client();

        $request = new Request('GET', 'https://blue-api.redsentry.com/v2/external/'.$this->dealer.'/report/' . $this->type, [
            'Authorization' => $token,
        ]);

        $status = $client->send($request)->getBody()->getContents();

        return Response::stream(function () use ($client, $request) {
            echo $client->send($request)->getBody()->getContents();

        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="report.pdf"',
        ]);
    }
}
