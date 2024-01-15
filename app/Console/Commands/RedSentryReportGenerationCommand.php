<?php

namespace App\Console\Commands;

use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Http;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RedSentryReportGenerationCommand extends Command
{
    protected $signature = 'red-sentry:report-generation {--tenants=* : The tenant(s) to run the command for. Default all.}';

    protected $description = 'Generate Technical and Executive Reports from Red Sentry';

    private $client;

    private $storage;

    public function __construct(Client $client, Storage $storage)
    {
        parent::__construct();

        $this->client = $client;
        $this->storage = $storage;
    }

    public function handle()
    {
        tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {

            $stores = Store::all();

            $storesWithScanSettings = $stores->filter(function ($store) {
                return $store->scanSetting->name ?? null;
            });

            if ($storesWithScanSettings->isNotEmpty()) {

                $scanTypes = ['external', 'internal'];
                $reportTypes = ['executive', 'technical'];

                $user = Http::post(env('RED_SENTRY_API_BASE_URL').'/login', [
                    'username' => env('RED_SENTRY_USER'),
                    'password' => env('RED_SENTRY_PASS'),
                ]);

                $token = $user['token'];

                foreach ($stores as $store) {

                    $this->info('Running for '.$store->name);
                    if ($store->name === 'Ken Houtz Chevrolet Buick') {
                        $this->info('Running for '.$store->name);
                        foreach ($scanTypes as $scanType) {
                            foreach ($reportTypes as $reportType) {

                                $lastRunDate = $store->scanReports()->where('scan_type', $scanType)->where('type', $reportType)->latest()->first()->last_scan ?? null;

                                $this->info('Last Run Date in database: '.$lastRunDate);

                                $this->generateReport($store, $scanType, $reportType, $token, $tenant, $lastRunDate);
                            }
                        }
                    }
                }

            }

            $token = null;

        });
    }

    private function generateReport($store, $scanType, $reportType, $token, $tenant, $lastRunDate)
    {
        $this->info('Running for '.$store->scanSetting->name);

        if ($store->scanSetting->name === null) {
            return;
        }

        if (tenant('locations')) {
            $dealerName = str_replace(' ', '-', $store->scanSetting->name);
        } else {
            $dealerName = str_replace(' ', '-', $tenant->name);
        }
        $fileName = $dealerName.'-'.now()->format('Ymdhis').'-'.$reportType.'.pdf';

        $statsRequest = new Request('GET', env('RED_SENTRY_API_BASE_URL').($scanType === 'external' ? '/v2' : '').'/'.$scanType.'/workbench?page=0&size=20&search='.$store->scanSetting->name.'&sort_dir=asc', [
            'Authorization' => $token,
        ]);

        $statsStatus = $this->client->send($statsRequest)->getBody()->getContents();

        $stats = json_decode($statsStatus);

        if (empty($stats)) {
            return;
        }

        $lastScan = $stats[0]->last_scan;
        $lastScanDate = DateTime::createFromFormat('m/d/Y - H:i:s', $lastScan);
        $lastScanFormatted = $lastScanDate->format('Y-m-d');

        $nextScan = $stats[0]->next_scan;
        $nextScanDate = DateTime::createFromFormat('m/d/Y - H:i:s', $nextScan);
        $nextScanFormatted = $nextScanDate->format('Y-m-d');

        $this->info('Last Scan: '.$lastScanFormatted);

        //        if ($lastRunDate != null && $lastScanFormatted === $lastRunDate) {
        //            return;
        //        }

        $reportRequest = new Request('GET', env('RED_SENTRY_API_BASE_URL').($scanType === 'external' ? '/v2' : '').'/'.$scanType.'/'.$store->scanSetting->name.'/report/'.$reportType, [
            'Authorization' => $token,
        ]);

        $reportStatus = $this->client->send($reportRequest)->getBody()->getContents();

        $this->storage::disk('do-scans')->put(tenant('id').'/'.$reportType.'/'.$fileName, $reportStatus);

        $this->createScanReport($store, $reportType, $scanType, $fileName, $stats, $lastScanFormatted, $nextScanFormatted, $tenant);
    }

    private function createScanReport($store, $reportType, $scanType, $fileName, $stats, $lastScanFormatted, $nextScanFormatted, $tenant)
    {
        ScanReport::create([
            'user_id' => 1,
            'store_id' => $store->id,
            'path' => $tenant->id.'/'.$reportType.'/'.$fileName,
            'type' => $reportType,
            'scan_type' => $scanType,
            'grade' => $stats[0]->grade,
            'exploits_high' => $stats[0]->exploits->high,
            'exploits_medium' => $stats[0]->exploits->medium,
            'exploits_low' => $stats[0]->exploits->low,
            'cves_high' => $stats[0]->cves->high,
            'cves_medium' => $stats[0]->cves->medium,
            'cves_low' => $stats[0]->cves->low,
            'assets' => $stats[0]->assets,
            'last_scan' => $lastScanFormatted,
            'next_scan' => $nextScanFormatted,
            'last_scan_status' => $stats[0]->last_scan_status,
            'last_scan_progress' => $stats[0]->last_scan_progress,
        ]);

    }
}
