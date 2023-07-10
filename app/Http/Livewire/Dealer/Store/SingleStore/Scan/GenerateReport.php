<?php

namespace App\Http\Livewire\Dealer\Store\SingleStore\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use Cookie;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class GenerateReport extends Component
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
        $this->tech = $this->store->scanReports()->where('type', 'technical')->latest()->select('created_at')->first();
        $this->exec = $this->store->scanReports()->where('type', 'executive')->latest()->select('created_at')->first();

        $this->dealer = $this->store->scanSetting()->first()->name;
    }

    public function export() {
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

        return redirect()->route('dealer.stores.scans', $this->store);
    }

    public function render()
    {
        return view('livewire.dealer.store.single-store.scan.generate-report');
    }
}
