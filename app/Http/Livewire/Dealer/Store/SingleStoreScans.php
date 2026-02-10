<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Store;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Livewire\Component;

class SingleStoreScans extends Component
{
    public $store;
    public string $type = 'technical';
    public string $dealer;

    public function mount(Store $store): void
    {
        if ($store->id === null) {
            $this->dealer = ScanSetting::query()->first()->name ?? '';
        } else {
            $this->dealer = ScanSetting::query()->where('store_id', $this->store->id)->first()->name ?? '';
        }
    }

    public function export()
    {
        $token = Cookie::get('sentry');
        $client = new Client;

        $request = new Request('GET', 'https://blue-api.redsentry.com/v2/external/'.$this->dealer.'/report/'.$this->type, [
            'Authorization' => $token,
        ]);

        $client->send($request)->getBody()->getContents();

        return Response::stream(function () use ($client, $request): void {
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
