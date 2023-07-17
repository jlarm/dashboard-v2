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

class InternalReportGenerator extends Component
{
    public $token;
    public $status;
    public string $type = 'technical';
    public string $dealer;
    public $assets;
    public $reports;
    public Store $store;
    public $internal;
    public $external;

    public function mount()
    {
        if(tenant('locations')) {
            $this->store = Store::where('id', $this->store->id)->first() ?? '';
        } else {
            $this->dealer = ScanSetting::first()->name ?? '';
        }
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

        try {
            $request = new Request('GET', 'https://blue-api.redsentry.com/v2/internal/'.$this->dealer.'/report/' . $this->type, [
                'Authorization' => $token,
            ]);

            $status = $client->send($request)->getBody()->getContents();

            Storage::disk('do-scans')->put(tenant('id') . '/internal/' . $this->type . '/' . $fileName, $status);

            ScanReport::create([
                'user_id' => auth()->id(),
                'store_id' => $this->store->id ?? Store::first()->id,
                'path' => tenant('id') . '/external/' . $this->type . '/' . $fileName,
                'type' => $this->type,
                'scan_type' => 'internal',
            ]);
        } catch(\Exception $e) {
            $this->addError('connection', 'Error connecting to Sentry. Please check the dealership name in settings.');
        }

    }
    public function render()
    {
        return view('livewire.dealer.scan.internal-report-generator');
    }
}
