<?php

declare(strict_types=1);

namespace App\Jobs\Scans;

use App\Models\Dealer\Store;
use App\Models\User;
use App\Services\CyrismaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPdfWrapper;
use Carbon\Carbon;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateCyrismaReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /** @var int Timeout in seconds — Cyrisma API calls can be slow on a cold cache */
    public int $timeout = 300;

    public function __construct(
        private readonly int $storeId,
        private readonly string $type,
        private readonly int $userId,
    ) {}

    public function middleware(): array
    {
        return [(new WithoutOverlapping(static::class.'-'.$this->storeId.'-'.$this->type))->expireAfter(360)];
    }

    public function handle(): void
    {
        Log::info('GenerateCyrismaReportJob started', ['store_id' => $this->storeId, 'type' => $this->type]);

        $store = Store::query()->with('cyrisma')->findOrFail($this->storeId);

        $cyrisma = app(CyrismaService::class)->forStore($store);

        Log::info('GenerateCyrismaReportJob building report data', ['store_id' => $this->storeId]);

        $data = $this->buildReportData($cyrisma, $store);

        Log::info('GenerateCyrismaReportJob rendering PDF', ['store_id' => $this->storeId]);

        $view = $this->type === 'executive'
            ? 'tenant.scans.reports.executive'
            : 'tenant.scans.reports.technical';

        $pdf = Pdf::loadView($view, $data)->setPaper('letter');

        if ($this->type === 'technical') {
            $this->addTechnicalPageNumbers($pdf);
        }

        $pdfBinary = $pdf->output();

        $cacheKey = sprintf('cyrisma_report_pdf_v2_%d_%s', $this->storeId, $this->type);
        Cache::put($cacheKey, $pdfBinary, now()->addMinutes(30));

        Log::info('GenerateCyrismaReportJob complete', ['store_id' => $this->storeId, 'type' => $this->type]);

        $this->sendReadyNotification($store);
    }

    public function failed(?Throwable $exception): void
    {
        Log::error('GenerateCyrismaReportJob failed', [
            'store_id' => $this->storeId,
            'type' => $this->type,
            'error' => $exception?->getMessage(),
        ]);

        $user = User::query()->find($this->userId);
        $storeName = Store::query()->find($this->storeId)?->name ?? 'your store';

        if ($user instanceof User) {
            Notification::make()
                ->title('Report Generation Failed')
                ->body('We were unable to generate the '.ucfirst($this->type).' report for '.$storeName.'. Please try again.')
                ->danger()
                ->sendToDatabase($user)
                ->send();
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function buildReportData(CyrismaService $cyrisma, Store $store): array
    {
        $overall = $cyrisma->getOverallDashboard() ?? [];
        $vulnerabilityScans = $cyrisma->getVulnerabilityScans() ?? [];
        $scanList = $vulnerabilityScans['vulnerability_scans'] ?? [];
        $issueCounts = $scanList[0] ?? [];

        $lastScanDate = null;
        if (! empty($scanList)) {
            $latestScan = collect($scanList)->sortByDesc('scan_finished')->first();
            if (! empty($latestScan['scan_finished'])) {
                $lastScanDate = Carbon::parse($latestScan['scan_finished'])->format('M j, Y');
            }
        }

        $externalScanData = $cyrisma->getExternalIpScanData();
        $externalAssets = is_array($externalScanData) ? ($externalScanData['assets'] ?? []) : [];
        $externalAssets = $this->enrichExternalAssets($cyrisma, $externalAssets);
        $externalScanInfo = is_array($externalScanData) ? ($externalScanData['scan_info'] ?? []) : [];
        $externalAssetCount = count($externalAssets);

        $internalVulnerabilities = $cyrisma->getVulnerabilitiesByAssetType('internal');
        $internalVulnCount = count($internalVulnerabilities['vulnerabilities'] ?? []);

        $cveDetails = $cyrisma->getCveDetails() ?? [];
        $cveItems = array_slice($cveDetails['cve_items'] ?? [], 1);
        $openPorts = $cyrisma->getOpenPortsByAssetType();

        return [
            'storeName' => $store->name,
            'generatedAt' => now()->format('M j, Y g:i A'),
            'lastScanDate' => $lastScanDate,
            'overall' => $overall,
            'issueCounts' => $issueCounts,
            'externalAssetCount' => $externalAssetCount,
            'internalVulnCount' => $internalVulnCount,
            'externalAssets' => $externalAssets,
            'externalScanInfo' => $externalScanInfo,
            'cveItems' => $cveItems,
            'openPorts' => $openPorts,
        ];
    }

    private function addTechnicalPageNumbers(DomPdfWrapper $pdf): void
    {
        $pdf->render();

        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font = $fontMetrics->getFont('DejaVu Sans', 'normal');

        $canvas->page_script(function (int $pageNumber, int $pageCount, $canvas) use ($font, $fontMetrics): void {
            if ($pageNumber <= 1) {
                return;
            }

            $text = sprintf('Page %d of %d', $pageNumber - 1, max($pageCount - 1, 1));
            $fontSize = 9;
            $textWidth = $fontMetrics->getTextWidth($text, $font, $fontSize);
            $x = ($canvas->get_width() - $textWidth) / 2;
            $y = $canvas->get_height() - 24;

            $canvas->text($x, $y, $text, $font, $fontSize, [0.42, 0.45, 0.5]);
        });
    }

    /**
     * @param  array<int, array<string, mixed>>  $externalAssets
     * @return array<int, array<string, mixed>>
     */
    private function enrichExternalAssets(CyrismaService $cyrisma, array $externalAssets): array
    {
        return collect($externalAssets)
            ->map(function (array $asset) use ($cyrisma): array {
                $reportFindings = $this->buildReportFindings($cyrisma, $asset);
                $asset['report_findings'] = $reportFindings;
                $asset['report_finding_count'] = count($reportFindings);

                return $asset;
            })
            ->all();
    }

    /**
     * @param  array<string, mixed>  $asset
     * @return array<int, array<string, mixed>>
     */
    private function buildReportFindings(CyrismaService $cyrisma, array $asset): array
    {
        // Skip web app endpoint discovery for plain IP assets — they will never have
        // web application findings and the brute-force discovery loop is expensive.
        $webApplicationFindings = $this->assetIsWebBased($asset)
            ? $cyrisma->getWebApplicationScanFindingsForAsset($asset)
            : [];

        if ($webApplicationFindings !== []) {
            return collect($webApplicationFindings)
                ->map(fn (array $finding): array => $this->normalizeReportFinding($finding, 'flaw'))
                ->sort($this->sortReportFindings(...))
                ->values()
                ->all();
        }

        return collect($asset['vulnerabilities'] ?? [])
            ->map(fn (array $finding): array => $this->normalizeReportFinding($finding, 'vulnerability'))
            ->merge(
                collect($asset['flaws'] ?? [])
                    ->map(fn (array $finding): array => $this->normalizeReportFinding($finding, 'flaw'))
            )
            ->sort($this->sortReportFindings(...))
            ->values()
            ->all();
    }

    /**
     * Returns true when the asset is a web/domain target rather than a raw IP.
     * Only web assets can have web application scan findings.
     *
     * @param  array<string, mixed>  $asset
     */
    /**
     * @param  array<string, mixed>  $asset
     */
    private function assetIsWebBased(array $asset): bool
    {
        // If the asset already has flaw data it came from a web app scan
        if (! empty($asset['flaws'])) {
            return true;
        }

        // If the asset has a valid IP address it is an IP-based asset — never has web app findings
        $ip = trim((string) ($asset['ipAddress'] ?? $asset['assetIp'] ?? $asset['ip'] ?? ''));
        if ($ip !== '' && filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        // If there is an explicit URL field it's a web asset
        $url = trim((string) ($asset['assetUrl'] ?? $asset['url'] ?? ''));
        if ($url !== '' && filter_var($url, FILTER_VALIDATE_URL)) {
            return true;
        }

        // If the name contains letters (not just digits, dots, and colons) treat as a hostname
        $name = trim((string) ($asset['name'] ?? ''));

        return $name !== '' && (bool) preg_match('/[a-z]/i', $name);
    }

    /**
     * @param  array<string, mixed>  $finding
     * @return array<string, mixed>
     */
    private function normalizeReportFinding(array $finding, string $type): array
    {
        $name = $type === 'flaw'
            ? $this->firstStringValue($finding, ['alertName', 'alertRef', 'name'], 'Unknown Flaw')
            : $this->firstStringValue($finding, ['title', 'cve', 'name'], 'Unknown Vulnerability');

        $riskLevel = ucfirst(mb_strtolower($this->firstStringValue($finding, ['riskLevel', 'severity'], 'Info')));
        $description = $this->firstStringValue($finding, ['description', 'alertDesc', 'alertDescription', 'desc', 'message', 'details'], '');
        $solution = $this->firstStringValue($finding, ['solution', 'alertSolution', 'remediation', 'recommendation', 'fix'], '');
        $instances = $this->extractReportInstances($finding);

        $affectedUrls = (int) ($finding['alertCount'] ?? $finding['findingsCount'] ?? $finding['affectedUrls'] ?? $finding['affected_urls'] ?? 0);
        if ($affectedUrls === 0 && $instances !== []) {
            $affectedUrls = count($instances);
        }

        return [
            'name' => $name,
            'riskLevel' => $riskLevel,
            'affectedUrls' => $affectedUrls,
            'description' => $description,
            'solution' => $solution,
            'references' => $this->extractReportReferences($finding),
            'instances' => $instances,
        ];
    }

    /**
     * @param  array<string, mixed>  $left
     * @param  array<string, mixed>  $right
     */
    private function sortReportFindings(array $left, array $right): int
    {
        $riskComparison = $this->reportSeverityWeight((string) ($right['riskLevel'] ?? '')) <=> $this->reportSeverityWeight((string) ($left['riskLevel'] ?? ''));
        if ($riskComparison !== 0) {
            return $riskComparison;
        }

        $affectedUrlsComparison = ((int) ($right['affectedUrls'] ?? 0)) <=> ((int) ($left['affectedUrls'] ?? 0));
        if ($affectedUrlsComparison !== 0) {
            return $affectedUrlsComparison;
        }

        return strcmp((string) ($left['name'] ?? ''), (string) ($right['name'] ?? ''));
    }

    private function reportSeverityWeight(string $riskLevel): int
    {
        return match (mb_strtolower($riskLevel)) {
            'critical' => 5,
            'high' => 4,
            'medium' => 3,
            'low' => 2,
            'info' => 1,
            default => 0,
        };
    }

    /**
     * @param  array<string, mixed>  $finding
     * @return array<int, string>
     */
    private function extractReportReferences(array $finding): array
    {
        foreach (['references', 'reference', 'alertReference', 'alertReferences', 'links', 'referenceLinks', 'referenceURLs'] as $key) {
            if (! array_key_exists($key, $finding)) {
                continue;
            }

            $references = $this->normalizeReportReferences($finding[$key]);
            if ($references !== []) {
                return $references;
            }
        }

        return [];
    }

    /**
     * @return array<int, string>
     */
    private function normalizeReportReferences(mixed $references): array
    {
        if (is_string($references)) {
            $cleanedReferences = $this->sanitizeReportText($references);

            return collect(preg_split('/[\r\n,]+/', $cleanedReferences) ?: [])
                ->map(fn (string $value): string => trim($value))
                ->filter(fn (string $value): bool => $value !== '')
                ->values()
                ->all();
        }

        if (! is_array($references)) {
            return [];
        }

        return collect($references)
            ->map(function (mixed $reference): string {
                if (is_scalar($reference)) {
                    return $this->sanitizeReportText((string) $reference);
                }

                if (! is_array($reference)) {
                    return '';
                }

                return $this->sanitizeReportText((string) ($reference['url'] ?? $reference['link'] ?? $reference['href'] ?? $reference['reference'] ?? ''));
            })
            ->filter(fn (string $value): bool => $value !== '')
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $finding
     * @return array<int, array<string, string>>
     */
    private function extractReportInstances(array $finding): array
    {
        $instanceSources = [];

        foreach (['instances', 'alertInstances', 'details', 'urls', 'targets', 'other'] as $key) {
            if (! array_key_exists($key, $finding)) {
                continue;
            }
            if ($finding[$key] === null) {
                continue;
            }
            $instanceSources[] = $finding[$key];
        }

        if ($instanceSources === []) {
            return [];
        }

        return collect($instanceSources)
            ->flatMap(fn (mixed $source): array => $this->normalizeReportInstanceSource($source))
            ->map(fn (mixed $instance): ?array => $this->normalizeReportInstanceRow($instance))
            ->filter(fn (?array $instance): bool => $instance !== null)
            ->filter(fn (array $instance): bool => ($instance['url'] ?? '-') !== '-'
                    || ($instance['parameters'] ?? '-') !== '-'
                    || ($instance['attack'] ?? '-') !== '-'
                    || ($instance['evidence'] ?? '-') !== '-')
            ->values()
            ->all();
    }

    /**
     * @return array<int, mixed>
     */
    private function normalizeReportInstanceSource(mixed $source): array
    {
        if ($source === null) {
            return [];
        }

        if (is_string($source)) {
            $trimmedSource = trim($source);

            if ($trimmedSource === '') {
                return [];
            }

            $jsonDecoded = json_decode($trimmedSource, true);
            if (is_array($jsonDecoded)) {
                return $this->normalizeReportInstanceSource($jsonDecoded);
            }

            $cleanedSource = $this->sanitizeReportText($trimmedSource);
            if ($cleanedSource === '') {
                return [];
            }

            $parts = preg_split('/[\r\n]+/u', $cleanedSource) ?: [];
            if (count($parts) <= 1) {
                $parts = preg_split('/,\s*/u', $cleanedSource) ?: [];
            }

            return collect($parts)
                ->map(fn (string $part): string => trim($part))
                ->filter(fn (string $part): bool => $part !== '')
                ->values()
                ->all();
        }

        if (! is_array($source)) {
            return [];
        }

        if (array_is_list($source)) {
            return $source;
        }

        $rowKeys = [
            'uri', 'Uri', 'url', 'URL', 'target', 'targetUrl', 'location',
            'method', 'Method', 'httpMethod',
            'param', 'Param', 'parameter', 'Parameter', 'parameters', 'Parameters',
            'attack', 'Attack', 'evidence', 'Evidence',
        ];

        foreach ($rowKeys as $key) {
            if (array_key_exists($key, $source)) {
                return [$source];
            }
        }

        foreach (['instances', 'details', 'urls', 'targets', 'items', 'data', 'rows'] as $nestedKey) {
            if (isset($source[$nestedKey])) {
                return $this->normalizeReportInstanceSource($source[$nestedKey]);
            }
        }

        return collect($source)
            ->map(function (mixed $value, string|int $key): array {
                $normalizedKey = is_string($key) ? $this->sanitizeReportText($key) : '';
                $normalizedValue = $this->stringifyReportValue($value);

                if (filter_var($normalizedKey, FILTER_VALIDATE_URL)) {
                    return [
                        'url' => $normalizedKey,
                        'method' => '-',
                        'parameters' => $normalizedValue,
                        'attack' => '-',
                        'evidence' => '-',
                    ];
                }

                return [
                    'url' => '-',
                    'method' => '-',
                    'parameters' => $normalizedValue !== '-' ? $normalizedValue : $normalizedKey,
                    'attack' => '-',
                    'evidence' => '-',
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return array<string, string>|null
     */
    private function normalizeReportInstanceRow(mixed $instance): ?array
    {
        if (is_scalar($instance)) {
            $value = $this->sanitizeReportText((string) $instance);
            if ($value === '') {
                return null;
            }

            if (filter_var($value, FILTER_VALIDATE_URL) && preg_match('/\.(js|css|map|json)(\?.*)?$/i', $value) === 1) {
                return [
                    'url' => '-',
                    'method' => '-',
                    'parameters' => $value,
                    'attack' => '-',
                    'evidence' => '-',
                ];
            }

            return [
                'url' => filter_var($value, FILTER_VALIDATE_URL) ? $value : '-',
                'method' => '-',
                'parameters' => filter_var($value, FILTER_VALIDATE_URL) ? '-' : $value,
                'attack' => '-',
                'evidence' => '-',
            ];
        }

        if (! is_array($instance)) {
            return null;
        }

        $row = [
            'url' => $this->firstStringValue($instance, ['uri', 'Uri', 'url', 'URL', 'target', 'targetUrl', 'location'], '-'),
            'method' => $this->firstStringValue($instance, ['method', 'Method', 'httpMethod'], '-'),
            'parameters' => $this->stringifyReportValue($instance['param'] ?? $instance['Param'] ?? $instance['parameter'] ?? $instance['Parameter'] ?? $instance['parameters'] ?? $instance['Parameters'] ?? null),
            'attack' => $this->stringifyReportValue($instance['attack'] ?? $instance['Attack'] ?? null),
            'evidence' => $this->stringifyReportValue($instance['evidence'] ?? $instance['Evidence'] ?? null),
        ];

        if ($row['url'] === '-' && $row['parameters'] === '-' && count($instance) === 1) {
            $firstKey = (string) array_key_first($instance);
            $firstValue = $instance[$firstKey];

            if (filter_var($firstKey, FILTER_VALIDATE_URL)) {
                $row['url'] = $firstKey;
                $row['parameters'] = $this->stringifyReportValue($firstValue);
            } else {
                $row['parameters'] = $this->stringifyReportValue($firstValue);
                if ($row['parameters'] === '-') {
                    $row['parameters'] = $this->sanitizeReportText($firstKey);
                }
            }
        }

        return $row;
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function firstStringValue(array $payload, array $keys, string $default = ''): string
    {
        foreach ($keys as $key) {
            if (! isset($payload[$key])) {
                continue;
            }
            if (! is_scalar($payload[$key])) {
                continue;
            }
            $value = $this->sanitizeReportText((string) $payload[$key]);
            if ($value !== '') {
                return $value;
            }
        }

        return $default;
    }

    private function stringifyReportValue(mixed $value): string
    {
        if ($value === null) {
            return '-';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value)) {
            $stringValue = $this->sanitizeReportText((string) $value);

            return $stringValue !== '' ? $stringValue : '-';
        }

        if (is_array($value)) {
            $flattened = collect($value)
                ->map(function (mixed $item): string {
                    if (is_scalar($item)) {
                        return $this->sanitizeReportText((string) $item);
                    }

                    if (is_array($item)) {
                        $encoded = json_encode($item);

                        return $encoded === false ? '' : $this->sanitizeReportText($encoded);
                    }

                    return '';
                })
                ->filter(fn (string $item): bool => $item !== '')
                ->implode(', ');

            return $flattened !== '' ? $flattened : '-';
        }

        return '-';
    }

    private function sanitizeReportText(string $value): string
    {
        $decodedValue = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $lineBreakValue = preg_replace('/<\s*br\s*\/?\s*>/iu', "\n", $decodedValue) ?? $decodedValue;
        $lineBreakValue = preg_replace('/<\s*\/?\s*p\s*>/iu', "\n", $lineBreakValue) ?? $lineBreakValue;
        $strippedValue = strip_tags($lineBreakValue);
        $spaceNormalizedValue = preg_replace('/[ \t]+/u', ' ', $strippedValue) ?? $strippedValue;
        $lineNormalizedValue = preg_replace('/\n{3,}/u', "\n\n", $spaceNormalizedValue) ?? $spaceNormalizedValue;

        return trim($lineNormalizedValue);
    }

    private function sendReadyNotification(Store $store): void
    {
        $user = User::query()->find($this->userId);

        if (! $user instanceof User) {
            return;
        }

        $downloadUrl = route('dealer.scan.report', ['type' => $this->type]);

        Notification::make()
            ->title(ucfirst($this->type).' Report Ready')
            ->body('Your '.ucfirst($this->type).' scan report for '.$store->name.' has been generated and is ready to download.')
            ->success()
            ->actions([
                Action::make('download')
                    ->label('Download Report')
                    ->url($downloadUrl)
                    ->openUrlInNewTab()
                    ->button(),
            ])
            ->sendToDatabase($user)
            ->send();
    }
}
