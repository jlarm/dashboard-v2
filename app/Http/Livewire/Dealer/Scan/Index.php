<?php

declare(strict_types=1);

namespace App\Http\Livewire\Dealer\Scan;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\ScanSetting;
use App\Models\Dealer\Store;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Index extends Component
{
    public $statusCode;
    public string $type = 'technical';
    public string $dealer;
    public $assets;
    public $reports;
    public Store $store;
    public $internal;
    public $external;

    public function mount(): void
    {
        if (tenant('locations')) {
            $this->dealer = ScanSetting::query()->where('store_id', $this->store->id)->first()->name ?? '';
        } else {
            $this->dealer = ScanSetting::query()->first()->name ?? '';
        }
    }

    public function export()
    {
        $dealerName = tenant('locations') ? str_replace(' ', '-', $this->store->name) : str_replace(' ', '-', tenant('name'));
        $fileName = $dealerName.'-'.now()->format('Ymdhis').'-'.$this->type.'.pdf';

        try {
            $token = Cookie::get('sentry');
            $client = new Client;

            $request = new Request('GET', 'https://blue-api.redsentry.com/v2/external/'.$this->dealer.'/report/'.$this->type, [
                'Authorization' => $token,
            ]);

            $status = $client->send($request)->getBody()->getContents();

            Storage::disk('do-scans')->put(tenant('id').'/'.$this->type.'/'.$fileName, $status);

            ScanReport::query()->create([
                'user_id' => auth()->id(),
                'store_id' => $this->store->id ?? Store::query()->first()->id,
                'path' => tenant('id').'/'.$this->type.'/'.$fileName,
                'type' => $this->type,
                'scan_type' => 'external',
            ]);

            if (tenant('locations')) {
                return redirect()->route('dealer.stores.scans', $this->store);
            }

            return redirect()->route('dealer.scan.index');

        } catch (Exception) {
            $this->addError('connection', 'Error connecting to Sentry. Please check the dealership name in settings.');
        }

        return null;

    }
}
