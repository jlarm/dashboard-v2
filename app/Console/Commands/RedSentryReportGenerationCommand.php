<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\RedSentryErrorNotification;
use App\Models\Dealer\ScanReport;
use App\Models\Dealer\Store;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Log;

class RedSentryReportGenerationCommand extends Command
{
    protected $signature = 'red-sentry:report-generation {--tenants=* : The tenant(s) to run the command for. Default all.}';
    protected $description = 'Generate Technical and Executive Reports from Red Sentry';

    private Client $client;
    private array $errors = [];

    public function __construct(Client $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    public function handle(): void
    {
        try {
            tenancy()->runForMultiple($this->option('tenants'), function ($tenant) {
                $stores = Store::with('scanSetting')->get();

                try {
                    $token = $this->authenticate();
                    $this->processStores($stores, $token, $tenant);
                } catch(Exception $e) {
                    $this->logError("Authentication error for tenant {$tenant->id}: {$e->getMessage()}");
                }
            });
        } catch (Exception $e) {
            $this->logError("General error: {$e->getMessage()}");
        }

        if (!empty($this->errors)) {
            $this->sendErrorNotification();
        }
    }

    private function logError(string $message): void
    {
        $this->error($message);
        $this->errors[] = $message;
    }

    private function sendErrorNotification(): void
    {
        $recipient = config('app.admin_email');

        if (!empty($recipient) && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            try {
                Mail::to($recipient)->send(new RedSentryErrorNotification($this->errors));
            } catch (Exception $e) {
                $this->error('Failed to send error notification: ' . $e->getMessage());
                Log::error('RedSentry error notification failed: ' . $e->getMessage(), [
                    'errors' => $this->errors
                ]);
            }
        } else {
            $this->error('Invalid or missing admin email configuration for error notifications: "' . $recipient . '"');
            Log::warning('RedSentry could not send error notification - invalid admin_email config', [
                'configured_email' => $recipient,
                'errors' => $this->errors
            ]);
        }
    }

    private function authenticate(): string
    {
        $response = Http::post(config('redsentry.url').'/login', [
            'username' => config('redsentry.username'),
            'password' => config('redsentry.password'),
        ]);

        return $response['token'];
    }

    private function processStores($stores, string $token, $tenant): void
    {
        $reportTypes = ['executive', 'technical'];

        foreach ($stores as $store) {
            $scanTypes = $this->scanTypes($store);

            foreach ($scanTypes as $scanType => $scanId) {

                if ($this->statusCheck($store, $scanType, $scanId, $token) !== 'done') {
                    $this->info("Scan not completed for store {$store->id}, scan type {$scanType}");
                    continue;
                }
            
                $lastRunDate = $this->getLastRunDate($scanType, $scanId, $token);
                if (!$lastRunDate) {
                    $this->info("No scan history found for store {$store->id}, scan type {$scanType}");
                    continue;
                }
                
                $stats = $this->getStats($store, $scanType, $scanId, $token);

                foreach ($reportTypes as $reportType) {
                    $localScanDate = $this->getLastStoredRunDate($store, $scanType, $reportType);
                    $externalScanDate = $this->getLastRunDate($scanType, $scanId, $token);

                    $existingReport = $store->latestScanReportDate()->where('type', $reportType)->first();
                    
                    if ($localScanDate === null || $externalScanDate > $localScanDate) {
                        $this->info("Generating {$reportType} report for store {$store->id}, scan type {$scanType}");
                        $this->generateReport($store, $scanType, $scanId, $reportType, $token, $tenant, $lastRunDate, $stats);
                    } else {
                        $this->info("Skipping report generation - no new scans available for store {$store->id}, scan type {$scanType}");
                    }
                }
            }
        }
    }

    private function statusCheck(Store $store, string $scanType, int $scanId, string $token): string
    {
        $request = new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/scan/status', [
            'Authorization' => $token,
        ]);
        $response = $this->client->send($request)->getBody()->getContents();
        $status = json_decode($response, true, 512, JSON_THROW_ON_ERROR);
        return $status['status'];
    }

    private function scanTypes(Store $store): array
    {
        $scanTypes = [];

        if ($store->scanSetting->internal_id) {
            $scanTypes['internal'] = $store->scanSetting->internal_id;
        }

        if ($store->scanSetting->external_id) {
            $scanTypes['external'] = $store->scanSetting->external_id;
        }

        return $scanTypes;
    }

    private function getStats($store, string $scanType, int $scanId, string $token): array
    {
        $grade = $this->fetchGrade($scanType, $scanId, $token);
        $exploits = $this->fetchExploits($store, $scanType, $scanId, $token);
        $cves = $this->fetchCves($store, $scanType, $scanId, $token);
        $results = [
            'grade' => $grade,
            'exploits' => $exploits,
            'cves' => $cves,
        ];

        return $results;
    }

    private function getLastStoredRunDate($store, string $scanType, string $reportType): ?string
    {
        $report = $store->latestScanReportDate()->where('type', $reportType)->first();

        return $report ? $report->last_scan : null;
    }

    private function getLastRunDate(string $scanType, int $scanId, string $token): ?string
    {
        $request = new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/scan/dates', [
            'Authorization' => $token,
        ]);
        $response = $this->client->send($request)->getBody()->getContents();
        $dates = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

        if (isset($dates[0]['id'])) {
            return $this->formatDate($dates[0]['date']);
        }

        return null;
    }

    private function generateReport($store, string $scanType, int $scanId, string $reportType, string $token, $tenant, $lastRunDate, $stats): void
    {
        try {
            $dealerName = $this->getDealerName($store, $tenant);
            $fileName = $this->generateFileName($dealerName, $reportType);

            if (!$stats) {
                $this->error('No valid scan data found for ' . $dealerName);
                return;
            }

            $reportStatus = $this->fetchReport($store, $scanType, $scanId, $reportType, $token);

            Storage::disk('do-scans')->put(tenant('id').'/'.$reportType.'/'.$fileName, $reportStatus);

            $this->createScanReport($store, $reportType, $scanType, $fileName, $stats, $tenant, $lastRunDate);
        } catch (Exception $e) {
            $this->logError("Error generating report for store {$store->id}, scan type {$scanType}: {$e->getMessage()}");
        }
    }

    private function getDealerName($store, $tenant): string
    {
        return str_replace(' ', '-', tenant('locations') ? $store->scanSetting->name : $tenant->name);
    }

    private function generateFileName(string $dealerName, string $reportType): string
    {
        return $dealerName.'-'.now()->format('Ymdhis').'-'.$reportType.'.pdf';
    }

    private function fetchGrade(string $scanType, int $scanId, string $token)
    {
        $statsRequest = new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/grade', [
            'Authorization' => $token,
        ]);

        $statsStatus = $this->client->send($statsRequest)->getBody()->getContents();
        $stats = json_decode($statsStatus);

        return $stats->grade;
    }

    private function fetchExploits($store, string $scanType, int $scanId, string $token): array
    {
        $request= new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/count/exploits', [
            'Authorization' => $token,
        ]);

        $status = $this->client->send($request)->getBody()->getContents();
        $stats = json_decode($status, true, 512, JSON_THROW_ON_ERROR);

        if (isset($stats[0]['name'])) {
            $data = array_combine(
                array_column($stats, 'name'),
                array_column($stats, 'value')
            );
        } else {
            $data = [
                'high' => $stats['high'] ?? 0,
                'medium' => $stats['medium'] ?? 0,
                'low' => $stats['low'] ?? 0,
            ];
        }

        return $data;
    }

    private function fetchCves($store, string $scanType, int $scanId, string $token): array
    {
        $request= new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/count/cves', [
            'Authorization' => $token,
        ]);

        $status = $this->client->send($request)->getBody()->getContents();
        $stats = json_decode($status, true);

        if (isset($stats[0]['name'])) {
            $data = array_combine(
                array_column($stats, 'name'),
                array_column($stats, 'value')
            );
        } else {
            $data = [
                'high' => $stats['high'] ?? 0,
                'medium' => $stats['medium'] ?? 0,
                'low' => $stats['low'] ?? 0,
            ];
        }

        return $data;
    }

    private function fetchReport($store, string $scanType, int $scanId, string $reportType, string $token): string
    {
        $request = new Request('GET', config('redsentry.url').'/v3/scanners/'.$scanType.'/'.$scanId.'/report/'.$reportType, [
            'Authorization' => $token,
        ]);

        return $this->client->send($request)->getBody()->getContents();
    }

    private function formatDate(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        try {
            $dateTime = DateTime::createFromFormat('m/d/Y - H:i:s', $date);
            if (!$dateTime) {
                $this->warn("Could not parse date: {$date}");
                return null;
            }
            return $dateTime->format('Y-m-d');
        } catch (Exception $e) {
            $this->warn("Error formatting date {$date}: {$e->getMessage()}");
            return null;
        }
    }

    private function createScanReport(
        $store,
        string $reportType,
        string $scanType,
        string $fileName,
        $stats,
        $tenant,
        $lastRunDate
    ): void
    {
        $this->info(json_encode($stats));

        ScanReport::create([
            'user_id' => 1,
            'store_id' => $store->id,
            'path' => $tenant->id.'/'.$reportType.'/'.$fileName,
            'type' => $reportType,
            'scan_type' => $scanType,
            'grade' => $stats['grade'] ?? null,
            'exploits_high' => $stats['exploits']['high'] ?? 0,
            'exploits_medium' => $stats['exploits']['medium'] ?? 0,
            'exploits_low' => $stats['exploits']['low'] ?? 0,
            'cves_high' => $stats['cves']['high'] ?? 0,
            'cves_medium' => $stats['cves']['medium'] ?? 0,
            'cves_low' => $stats['cves']['low'] ?? 0,
            'last_scan' => $lastRunDate,
        ]);
    }
}
