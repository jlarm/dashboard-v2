<?php

namespace App\Http\Livewire\Dealer\Store;

use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Cookie;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use Response;

class SingleStoreScans extends Component
{
    public $store;
    public string $type = 'technical';
    public string $dealer;

    public function mount(Store $store)
    {
        if ($store->id === null) {
            $this->dealer = ScanSetting::first()->name ?? '';
        } else {
            $this->dealer = ScanSetting::where('store_id', $this->store->id)->first()->name ?? '';
        }
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
    public function render()
    {
        return view('livewire.dealer.store.single-store-scans')->layout('components.dealer-app');
    }
}
