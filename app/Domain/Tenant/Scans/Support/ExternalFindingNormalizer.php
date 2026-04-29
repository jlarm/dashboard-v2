<?php

declare(strict_types=1);

namespace App\Domain\Tenant\Scans\Support;

use App\Domain\Tenant\Scans\Data\ExternalIpFindingData;

/**
 * Normalizes the wildly variable Cyrisma external-scan finding payloads into a
 * consistent shape for the Inertia frontend. Lifted from the original Livewire
 * ExternalIpExposure component — kept verbatim because the input format is
 * unstable and small changes here have caused production regressions before.
 */
final class ExternalFindingNormalizer
{
    /**
     * Build a sorted list of normalized findings for an asset, merging
     * vulnerabilities and flaws by risk weight then affected URL count.
     *
     * @param  array<string, mixed>  $asset
     * @return list<array{name: string, risk_level: string, affected_urls: int, description: string, solution: string, references: list<string>, instances: list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>}>
     */
    public static function findingsFor(array $asset): array
    {
        $vulnerabilities = is_array($asset['vulnerabilities'] ?? null) ? $asset['vulnerabilities'] : [];
        $flaws = is_array($asset['flaws'] ?? null) ? $asset['flaws'] : [];

        return collect($vulnerabilities)
            ->filter(static fn ($entry): bool => is_array($entry))
            ->map(static fn (array $entry): array => self::normalize($entry, 'vulnerability')->toArray())
            ->merge(
                collect($flaws)
                    ->filter(static fn ($entry): bool => is_array($entry))
                    ->map(static fn (array $entry): array => self::normalize($entry, 'flaw')->toArray()),
            )
            ->sort(static function (array $a, array $b): int {
                $byRisk = self::severityWeight((string) $b['risk_level']) <=> self::severityWeight((string) $a['risk_level']);
                if ($byRisk !== 0) {
                    return $byRisk;
                }

                $byAffected = ((int) $b['affected_urls']) <=> ((int) $a['affected_urls']);
                if ($byAffected !== 0) {
                    return $byAffected;
                }

                return strcmp((string) $a['name'], (string) $b['name']);
            })
            ->values()
            ->all();
    }

    /**
     * Normalize an enriched finding payload (e.g. from
     * getWebApplicationScanFindingsForAsset). Used by the detail dialog.
     *
     * @param  array<string, mixed>  $finding
     */
    public static function fromPayload(array $finding, string $type = 'flaw'): ExternalIpFindingData
    {
        return self::normalize($finding, $type);
    }

    /**
     * @param  array<string, mixed>  $finding
     */
    private static function normalize(array $finding, string $type): ExternalIpFindingData
    {
        $name = $type === 'flaw'
            ? self::firstStringValue($finding, ['alertName', 'alertRef', 'name'], 'Unknown Flaw')
            : self::firstStringValue($finding, ['title', 'cve', 'name'], 'Unknown Vulnerability');

        $riskLevel = ucfirst(mb_strtolower(self::firstStringValue($finding, ['riskLevel', 'severity'], 'Info')));
        $description = self::firstStringValue($finding, ['description', 'alertDesc', 'alertDescription', 'desc', 'message', 'details'], '');
        $solution = self::firstStringValue($finding, ['solution', 'alertSolution', 'remediation', 'recommendation', 'fix'], '');
        $instances = self::extractInstances($finding);

        $affectedUrls = (int) ($finding['alertCount'] ?? $finding['findingsCount'] ?? $finding['affectedUrls'] ?? $finding['affected_urls'] ?? 0);
        if ($affectedUrls === 0 && $instances !== []) {
            $affectedUrls = count($instances);
        }

        return new ExternalIpFindingData(
            name: $name,
            riskLevel: $riskLevel,
            affectedUrls: $affectedUrls,
            description: $description,
            solution: $solution,
            references: self::extractReferences($finding),
            instances: $instances,
        );
    }

    private static function severityWeight(string $riskLevel): int
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
     * @return list<string>
     */
    private static function extractReferences(array $finding): array
    {
        foreach (['references', 'reference', 'alertReference', 'alertReferences', 'links', 'referenceLinks', 'referenceURLs'] as $key) {
            if (! array_key_exists($key, $finding)) {
                continue;
            }

            $references = self::normalizeReferences($finding[$key]);
            if ($references !== []) {
                return $references;
            }
        }

        return [];
    }

    /**
     * @return list<string>
     */
    private static function normalizeReferences(mixed $references): array
    {
        if (is_string($references)) {
            $cleaned = self::sanitizeText($references);

            return collect(preg_split('/[\r\n,]+/', $cleaned) ?: [])
                ->map(static fn (string $value): string => mb_trim($value))
                ->filter(static fn (string $value): bool => $value !== '')
                ->values()
                ->all();
        }

        if (! is_array($references)) {
            return [];
        }

        return collect($references)
            ->map(static function (mixed $reference): string {
                if (is_scalar($reference)) {
                    return self::sanitizeText((string) $reference);
                }

                if (! is_array($reference)) {
                    return '';
                }

                return self::sanitizeText((string) ($reference['url'] ?? $reference['link'] ?? $reference['href'] ?? $reference['reference'] ?? ''));
            })
            ->filter(static fn (string $value): bool => $value !== '')
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $finding
     * @return list<array{url: string, method: string, parameters: string, attack: string, evidence: string}>
     */
    private static function extractInstances(array $finding): array
    {
        $sources = [];

        foreach (['instances', 'alertInstances', 'details', 'urls', 'targets', 'other'] as $key) {
            if (! array_key_exists($key, $finding)) {
                continue;
            }
            if ($finding[$key] === null) {
                continue;
            }
            $sources[] = $finding[$key];
        }

        if ($sources === []) {
            return [];
        }

        return collect($sources)
            ->flatMap(static fn (mixed $source): array => self::normalizeInstanceSource($source))
            ->map(static fn (mixed $instance): ?array => self::normalizeInstanceRow($instance))
            ->filter(static fn (?array $instance): bool => $instance !== null)
            ->filter(static fn (array $instance): bool => ($instance['url'] ?? '-') !== '-'
                || ($instance['parameters'] ?? '-') !== '-'
                || ($instance['attack'] ?? '-') !== '-'
                || ($instance['evidence'] ?? '-') !== '-')
            ->values()
            ->all();
    }

    /**
     * @return array<int, mixed>
     */
    private static function normalizeInstanceSource(mixed $source): array
    {
        if ($source === null) {
            return [];
        }

        if (is_string($source)) {
            $trimmed = mb_trim($source);

            if ($trimmed === '') {
                return [];
            }

            $jsonDecoded = json_decode($trimmed, true);
            if (is_array($jsonDecoded)) {
                return self::normalizeInstanceSource($jsonDecoded);
            }

            $cleaned = self::sanitizeText($trimmed);
            if ($cleaned === '') {
                return [];
            }

            $parts = preg_split('/[\r\n]+/u', $cleaned) ?: [];
            if (count($parts) <= 1) {
                $parts = preg_split('/,\s*/u', $cleaned) ?: [];
            }

            return collect($parts)
                ->map(static fn (string $part): string => mb_trim($part))
                ->filter(static fn (string $part): bool => $part !== '')
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
                return self::normalizeInstanceSource($source[$nestedKey]);
            }
        }

        return collect($source)
            ->map(static function (mixed $value, string|int $key): array {
                $normalizedKey = is_string($key) ? self::sanitizeText($key) : '';
                $normalizedValue = self::stringifyValue($value);

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
     * @return array{url: string, method: string, parameters: string, attack: string, evidence: string}|null
     */
    private static function normalizeInstanceRow(mixed $instance): ?array
    {
        if (is_scalar($instance)) {
            $value = self::sanitizeText((string) $instance);
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
            'url' => self::firstStringValue($instance, ['uri', 'Uri', 'url', 'URL', 'target', 'targetUrl', 'location'], '-'),
            'method' => self::firstStringValue($instance, ['method', 'Method', 'httpMethod'], '-'),
            'parameters' => self::stringifyValue($instance['param'] ?? $instance['Param'] ?? $instance['parameter'] ?? $instance['Parameter'] ?? $instance['parameters'] ?? $instance['Parameters'] ?? null),
            'attack' => self::stringifyValue($instance['attack'] ?? $instance['Attack'] ?? null),
            'evidence' => self::stringifyValue($instance['evidence'] ?? $instance['Evidence'] ?? null),
        ];

        if ($row['url'] === '-' && $row['parameters'] === '-' && count($instance) === 1) {
            $firstKey = (string) array_key_first($instance);
            $firstValue = $instance[$firstKey];

            if (filter_var($firstKey, FILTER_VALIDATE_URL)) {
                $row['url'] = $firstKey;
                $row['parameters'] = self::stringifyValue($firstValue);
            } else {
                $row['parameters'] = self::stringifyValue($firstValue);
                if ($row['parameters'] === '-') {
                    $row['parameters'] = self::sanitizeText($firstKey);
                }
            }
        }

        return $row;
    }

    /**
     * @param  array<string, mixed>  $payload
     * @param  list<string>  $keys
     */
    private static function firstStringValue(array $payload, array $keys, string $default = ''): string
    {
        foreach ($keys as $key) {
            if (! isset($payload[$key])) {
                continue;
            }
            if (! is_scalar($payload[$key])) {
                continue;
            }
            $value = self::sanitizeText((string) $payload[$key]);
            if ($value !== '') {
                return $value;
            }
        }

        return $default;
    }

    private static function stringifyValue(mixed $value): string
    {
        if ($value === null) {
            return '-';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_scalar($value)) {
            $stringValue = self::sanitizeText((string) $value);

            return $stringValue !== '' ? $stringValue : '-';
        }

        if (is_array($value)) {
            $flattened = collect($value)
                ->map(static function (mixed $item): string {
                    if (is_scalar($item)) {
                        return mb_trim((string) $item);
                    }

                    if (is_array($item)) {
                        $encoded = json_encode($item);

                        return $encoded === false ? '' : $encoded;
                    }

                    return '';
                })
                ->filter(static fn (string $item): bool => $item !== '')
                ->implode(', ');

            return $flattened !== '' ? $flattened : '-';
        }

        return '-';
    }

    private static function sanitizeText(string $value): string
    {
        $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $lineBreak = preg_replace('/<\s*br\s*\/?\s*>/iu', "\n", $decoded) ?? $decoded;
        $lineBreak = preg_replace('/<\s*\/?\s*p\s*>/iu', "\n", $lineBreak) ?? $lineBreak;
        $stripped = strip_tags($lineBreak);
        $spaceNormalized = preg_replace('/[ \t]+/u', ' ', $stripped) ?? $stripped;
        $lineNormalized = preg_replace('/\n{3,}/u', "\n\n", $spaceNormalized) ?? $spaceNormalized;

        return mb_trim($lineNormalized);
    }
}
