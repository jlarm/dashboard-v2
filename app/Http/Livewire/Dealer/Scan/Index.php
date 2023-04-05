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

    public function mount()
    {
        $this->dealer = ScanSetting::first()->name ?? '';
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
