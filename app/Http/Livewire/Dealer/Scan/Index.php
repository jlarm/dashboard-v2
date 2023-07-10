<?php

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Cookie;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class   Index extends Component
{
    public string $type = 'technical';
    public string $dealer;
    public $assets;
    public $reports;
    public Store $store;
    public $tech;
    public $exec;

    public function mount()
    {
        $this->tech = ScanReport::where('type', 'technical')->latest()->select('created_at')->first();
        $this->exec = ScanReport::where('type', 'executive')->latest()->select('created_at')->first();
//        $this->reports = Storage::disk('do-scans')->allFiles(tenant('id'));
//        $statToken = Cookie::get('sentry');
//        $statClient = new Client();
//        $statNames = ['live_assets', 'root_domains', 'subdomains'];
        $this->dealer = ScanSetting::first()->name ?? '';
//
//        $statRequest = new Request('GET', 'https://blue-api.redsentry.com/external/stats/total/live_assets?sentry=Victor%20Ford', [
//            'Authorization' => $statToken,
//        ]);
//
//        $send = $statClient->send($statRequest)->getBody()->getContents();
//
//        $this->assets = json_decode($send);
//
//        $this->assets = $this->assets->total;
    }

    public function export()
    {
        $token = Cookie::get('sentry');
        $client = new Client();

        if(tenant('locations')){
            $dealerName = str_replace(' ', '-', $this->store->name);
        } else {
            $dealerName = str_replace(' ', '-', tenant('name'));
        }
        $fileName = $dealerName .'-'. now()->format('Ymdhis') .'-'.$this->type.'.pdf';

        $request = new Request('GET', 'https://blue-api.redsentry.com/v2/external/'.$this->dealer.'/report/' . $this->type, [
            'Authorization' => $token,
        ]);

        $status = $client->send($request)->getBody()->getContents();

        Storage::disk('do-scans')->put(tenant('id') . '/' . $this->type . '/' . $fileName, $status);

        ScanReport::create([
            'user_id' => auth()->id(),
            'store_id' => $this->store->id ?? Store::first()->id,
            'path' => tenant('id') . '/' . $this->type . '/' . $fileName,
            'type' => $this->type,
        ]);

        return redirect()->route('dealer.scan.index');

//        return Response::stream(function () use ($client, $request) {
//            echo $client->send($request)->getBody()->getContents();
//
//        }, 200, [
//            'Content-Type' => 'application/pdf',
//            'Content-Disposition' => 'attachment; filename="report.pdf"',
//        ]);

    }
}
