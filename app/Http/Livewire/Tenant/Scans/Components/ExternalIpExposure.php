<?php

declare(strict_types=1);

namespace App\Http\Livewire\Tenant\Scans\Components;

use App\Models\Dealer\Store;
use App\Services\CyrismaService;
use Illuminate\View\View;
use Livewire\Component;

class ExternalIpExposure extends Component
{
    public int $storeId = 0;
    public array $scanInfo = [];
    public array $externalAssets = [];
    public ?array $selectedFinding = null;
    public bool $isFindingModalOpen = false;
    protected CyrismaService $cyrisma;

    public function mount(CyrismaService $cyrisma): void
    {
        $current = app('currentStore');
        $this->storeId = $current instanceof Store ? $current->id : (int) $current;

        $this->cyrisma = $cyrisma;
        $data = $this->cyrisma->getExternalIpScanData();

        if ($data) {
            $this->scanInfo = $data['scan_info'] ?? [];
            $this->externalAssets = $data['assets'] ?? [];
        }
    }

    public function render(): View
    {
        return view('livewire.tenant.scans.components.external-ip-exposure');
    }

    public function getTotalVulnerabilities(array $asset): int
    {
        return count($this->getFindingsBySeverity($asset));
    }

    public function getVulnerabilityCounts(array $asset): array
    {
        $critical = 0;
        $high = 0;
        $medium = 0;
        $low = 0;

        foreach ($this->getFindingsBySeverity($asset) as $finding) {
            $riskLevel = mb_strtolower((string) ($finding['riskLevel'] ?? ''));

            match ($riskLevel) {
                'critical' => $critical++,
                'high' => $high++,
                'medium' => $medium++,
                'low' => $low++,
                default => null,
            };
        }

        return ['critical' => $critical, 'high' => $high, 'medium' => $medium, 'low' => $low];
    }

    public function getFindingsBySeverity(array $asset): array
    {
        return collect($asset['vulnerabilities'] ?? [])
            ->map(fn (array $vulnerability): array => $this->normalizeFinding($vulnerability, 'vulnerability'))
            ->merge(
                collect($asset['flaws'] ?? [])->map(fn (array $flaw): array => $this->normalizeFinding($flaw, 'flaw'))
            )
            ->sort(function (array $a, array $b): int {
                $riskComparison = $this->getSeverityWeight((string) ($b['riskLevel'] ?? '')) <=> $this->getSeverityWeight((string) ($a['riskLevel'] ?? ''));
                if ($riskComparison !== 0) {
                    return $riskComparison;
                }

                $affectedUrlsComparison = ((int) ($b['affectedUrls'] ?? 0)) <=> ((int) ($a['affectedUrls'] ?? 0));
                if ($affectedUrlsComparison !== 0) {
                    return $affectedUrlsComparison;
                }

                return strcmp((string) ($a['name'] ?? ''), (string) ($b['name'] ?? ''));
            })
            ->values()
            ->all();
    }

    public function openFindingModal(int $assetIndex, int $findingIndex): void
    {
        if (! isset($this->externalAssets[$assetIndex])) {
            return;
        }

        $asset = $this->externalAssets[$assetIndex];
        $findings = $this->getFindingsBySeverity($asset);
        if (! isset($findings[$findingIndex])) {
            return;
        }

        $this->selectedFinding = $findings[$findingIndex];

        if ($this->needsFindingDetails($this->selectedFinding)) {
            $enrichedFinding = $this->loadFindingDetails($asset, (string) ($this->selectedFinding['name'] ?? ''));
            if ($enrichedFinding !== null) {
                $this->selectedFinding = array_merge($this->selectedFinding, $enrichedFinding);
            }
        }

        $this->isFindingModalOpen = true;
    }

    public function closeFindingModal(): void
    {
        $this->selectedFinding = null;
        $this->isFindingModalOpen = false;
    }

    public function getRiskColor(int $critical, int $high): string
    {
        if ($critical > 0) {
            return 'red';
        }

        if ($high >= 5) {
            return 'orange';
        }

        if ($high > 0) {
            return 'yellow';
        }

        return 'green';
    }

    protected function getSeverityWeight(string $riskLevel): int
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

    protected function normalizeFinding(array $finding, string $type): array
    {
        $name = $type === 'flaw'
            ? $this->firstStringValue($finding, ['alertName', 'alertRef', 'name'], 'Unknown Flaw')
            : $this->firstStringValue($finding, ['title', 'cve', 'name'], 'Unknown Vulnerability');

        $riskLevel = ucfirst(mb_strtolower($this->firstStringValue($finding, ['riskLevel', 'severity'], 'Info')));
        $description = $this->firstStringValue($finding, ['description', 'alertDesc', 'alertDescription', 'desc', 'message', 'details'], '');
        $solution = $this->firstStringValue($finding, ['solution', 'alertSolution', 'remediation', 'recommendation', 'fix'], '');
        $instances = $this->extractInstances($finding);

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
            'references' => $this->extractReferences($finding),
            'instances' => $instances,
        ];
    }

    protected function needsFindingDetails(array $finding): bool
    {
        return empty($finding['description'])
            && empty($finding['solution'])
            && empty($finding['references'])
            && empty($finding['instances']);
    }

    protected function loadFindingDetails(array $asset, string $findingName): ?array
    {
        $store = Store::query()->find($this->storeId);
        if (! $store) {
            return null;
        }

        $details = app(CyrismaService::class)
            ->forStore($store)
            ->getWebApplicationScanFindingsForAsset($asset, $findingName);

        if ($details === []) {
            return null;
        }

        return $this->normalizeFinding($details[0], 'flaw');
    }

    protected function extractReferences(array $finding): array
    {
        foreach (['references', 'reference', 'alertReference', 'alertReferences', 'links', 'referenceLinks', 'referenceURLs'] as $key) {
            if (! array_key_exists($key, $finding)) {
                continue;
            }

            $references = $this->normalizeReferences($finding[$key]);
            if ($references !== []) {
                return $references;
            }
        }

        return [];
    }

    protected function normalizeReferences(mixed $references): array
    {
        if (is_string($references)) {
            $cleanedReferences = $this->sanitizeText($references);

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
                    return $this->sanitizeText((string) $reference);
                }

                if (! is_array($reference)) {
                    return '';
                }

                return $this->sanitizeText((string) ($reference['url'] ?? $reference['link'] ?? $reference['href'] ?? $reference['reference'] ?? ''));
            })
            ->filter(fn (string $value): bool => $value !== '')
            ->values()
            ->all();
    }

    protected function extractInstances(array $finding): array
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
            ->flatMap(fn (mixed $source): array => $this->normalizeInstanceSource($source))
            ->map(fn (mixed $instance): ?array => $this->normalizeInstanceRow($instance))
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
    protected function normalizeInstanceSource(mixed $source): array
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
                return $this->normalizeInstanceSource($jsonDecoded);
            }

            $cleanedSource = $this->sanitizeText($trimmedSource);
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
                return $this->normalizeInstanceSource($source[$nestedKey]);
            }
        }

        return collect($source)
            ->map(function (mixed $value, string|int $key): array {
                $normalizedKey = is_string($key) ? $this->sanitizeText($key) : '';
                $normalizedValue = $this->stringifyValue($value);

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

    protected function normalizeInstanceRow(mixed $instance): ?array
    {
        if (is_scalar($instance)) {
            $value = $this->sanitizeText((string) $instance);
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
            'parameters' => $this->stringifyValue($instance['param'] ?? $instance['Param'] ?? $instance['parameter'] ?? $instance['Parameter'] ?? $instance['parameters'] ?? $instance['Parameters'] ?? null),
            'attack' => $this->stringifyValue($instance['attack'] ?? $instance['Attack'] ?? null),
            'evidence' => $this->stringifyValue($instance['evidence'] ?? $instance['Evidence'] ?? null),
        ];

        if ($row['url'] === '-' && $row['parameters'] === '-' && count($instance) === 1) {
            $firstKey = (string) array_key_first($instance);
            $firstValue = $instance[$firstKey];

            if (filter_var($firstKey, FILTER_VALIDATE_URL)) {
                $row['url'] = $firstKey;
                $row['parameters'] = $this->stringifyValue($firstValue);
            } else {
                $row['parameters'] = $this->stringifyValue($firstValue);
                if ($row['parameters'] === '-') {
                    $row['parameters'] = $this->sanitizeText($firstKey);
                }
            }
        }

        return $row;
    }

    protected function firstStringValue(array $payload, array $keys, string $default = ''): string
    {
        foreach ($keys as $key) {
            if (! isset($payload[$key])) {
                continue;
            }
            if (! is_scalar($payload[$key])) {
                continue;
            }
            $value = $this->sanitizeText((string) $payload[$key]);
            if ($value !== '') {
                return $value;
            }
        }

        return $default;
    }

    protected function stringifyValue(mixed $value): string
    {
        if ($value === null) {
            return '-';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value)) {
            $stringValue = $this->sanitizeText((string) $value);

            return $stringValue !== '' ? $stringValue : '-';
        }

        if (is_array($value)) {
            $flattened = collect($value)
                ->map(function (mixed $item): string {
                    if (is_scalar($item)) {
                        return trim((string) $item);
                    }

                    if (is_array($item)) {
                        $encoded = json_encode($item);

                        return $encoded === false ? '' : $encoded;
                    }

                    return '';
                })
                ->filter(fn (string $item): bool => $item !== '')
                ->implode(', ');

            return $flattened !== '' ? $flattened : '-';
        }

        return '-';
    }

    protected function sanitizeText(string $value): string
    {
        $decodedValue = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $lineBreakValue = preg_replace('/<\s*br\s*\/?\s*>/iu', "\n", $decodedValue) ?? $decodedValue;
        $lineBreakValue = preg_replace('/<\s*\/?\s*p\s*>/iu', "\n", $lineBreakValue) ?? $lineBreakValue;
        $strippedValue = strip_tags($lineBreakValue);
        $spaceNormalizedValue = preg_replace('/[ \t]+/u', ' ', $strippedValue) ?? $strippedValue;
        $lineNormalizedValue = preg_replace('/\n{3,}/u', "\n\n", $spaceNormalizedValue) ?? $spaceNormalizedValue;

        return trim($lineNormalizedValue);
    }
}
