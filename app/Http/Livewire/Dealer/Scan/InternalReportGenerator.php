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

    public function mount(): void
    {
        if (tenant('locations')) {
            $this->store = Store::query()->where('id', $this->store->id)->first() ?? '';
        } else {
            $this->dealer = ScanSetting::query()->first()->name ?? '';
        }
    }

    public function export(): void
    {
        $token = Cookie::get('sentry');
        $client = new Client;

        $dealerName = tenant('locations') ? str_replace(' ', '-', $this->store->name) : str_replace(' ', '-', tenant('name'));

        $fileName = $dealerName.'-'.now()->format('Ymdhis').'-internal-scan.pdf';

        try {
            $request = new Request('GET', 'https://blue-api.redsentry.com/internal/'.$this->dealer.'/report/executive?format=pdf&scan_id=latest', [
                'Authorization' => $token,
            ]);

            $status = $client->send($request)->getBody()->getContents();

            Storage::disk('do-scans')->put(tenant('id').'/internal/'.$fileName, $status);

            ScanReport::query()->create([
                'user_id' => auth()->id(),
                'store_id' => $this->store->id ?? Store::query()->first()->id,
                'path' => tenant('id').'/internal/'.$fileName,
                'type' => 'external',
                'scan_type' => 'internal',
            ]);
        } catch (Exception) {
            $this->addError('connection', 'Error connecting to Sentry. Please check the dealership name in settings.');
        }

    }

    public function render()
    {
        return view('livewire.dealer.scan.internal-report-generator');
    }
}
