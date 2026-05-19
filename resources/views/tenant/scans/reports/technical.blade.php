<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Technical Scan Report</title>
    @include('tenant.scans.reports._fonts')
    @include('tenant.scans.reports._styles')
</head>
<body>
@php
    $metaRows = [
        ['label' => 'Generated', 'value' => $generatedAt ?? null],
        ['label' => 'Last Scan', 'value' => $lastScanDate ?? null],
    ];
@endphp

@include('tenant.scans.reports._cover', ['reportType' => 'Technical', 'storeName' => $storeName, 'metaRows' => $metaRows])

{{-- ==================== Section 01 — Overall Risk Assessment ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">01 · Posture</div>
        <div class="section-title">Overall Risk Assessment</div>
        <div class="section-sub">Current security posture across all scan types.</div>
    </div>
    <div class="section-rule"></div>
    <table class="metrics">
        <tr>
            <td class="metric-cell" style="width: 50%;">
                <div class="metric-label">Overall Risk Grade</div>
                <div class="metric-value">{{ $overall['current_or_grade'] ?? '—' }}</div>
                <div class="metric-foot">Previous period: {{ $overall['previous_or_grade'] ?? '—' }}</div>
            </td>
            <td class="metric-cell" style="width: 50%;">
                <div class="metric-label">Vulnerability Grade</div>
                <div class="metric-value">{{ $overall['current_vn_grade'] ?? '—' }}</div>
                <div class="metric-foot">Previous period: {{ $overall['previous_vn_grade'] ?? '—' }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ==================== Section 02 — Issue Summary ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">02 · Summary</div>
        <div class="section-title">Issue Counts by Severity</div>
    </div>
    <div class="section-rule"></div>
    <table class="metrics">
        <tr>
            <td class="metric-cell">
                <div class="metric-label">Total Issues</div>
                <div class="metric-value">{{ $issueCounts['vulnerabilities'] ?? '—' }}</div>
            </td>
            <td class="metric-cell">
                <div class="metric-label">Critical</div>
                <div class="metric-value sev-critical">{{ $issueCounts['critical_vulnerabilities'] ?? '—' }}</div>
            </td>
            <td class="metric-cell">
                <div class="metric-label">High</div>
                <div class="metric-value sev-high">{{ $issueCounts['high_vulnerabilities'] ?? '—' }}</div>
            </td>
            <td class="metric-cell">
                <div class="metric-label">Medium</div>
                <div class="metric-value sev-medium">{{ $issueCounts['medium_vulnerabilities'] ?? '—' }}</div>
            </td>
            <td class="metric-cell">
                <div class="metric-label">Low</div>
                <div class="metric-value sev-low">{{ $issueCounts['low_vulnerabilities'] ?? '—' }}</div>
            </td>
            <td class="metric-cell">
                <div class="metric-label">Grade</div>
                <div class="metric-value">{{ $issueCounts['grade_alpha'] ?? '—' }}</div>
            </td>
        </tr>
    </table>
</div>

{{-- ==================== Section 03 — External IP Attack Surface ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">03 · Attack Surface</div>
        <div class="section-title">External IP Attack Surface</div>
        <div class="section-sub">
            Last scanned: {{ $externalScanInfo['scan_finished'] ?? '—' }}
            &nbsp;·&nbsp; {{ isset($externalAssets) ? count($externalAssets) : 0 }} external assets
        </div>
    </div>
    <div class="section-rule"></div>

    @forelse($externalAssets ?? [] as $asset)
        @php
            $assetOpenPorts = $asset['openPorts'] ?? [];
            $reportFindings = $asset['report_findings'] ?? [];
            $critical = 0; $high = 0; $medium = 0; $low = 0;
            foreach ($reportFindings as $finding) {
                $r = strtolower($finding['riskLevel'] ?? '');
                if ($r === 'critical') { $critical++; }
                elseif ($r === 'high') { $high++; }
                elseif ($r === 'medium') { $medium++; }
                elseif ($r === 'low') { $low++; }
            }
            $total = $critical + $high + $medium + $low;
            $assetRisk = 'Clean';
            if ($critical > 0) { $assetRisk = 'Critical'; }
            elseif ($high > 0) { $assetRisk = 'High'; }
            elseif ($medium > 0) { $assetRisk = 'Medium'; }
            elseif ($low > 0) { $assetRisk = 'Low'; }
        @endphp
        <div class="asset-card">
            <div class="asset-head">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>
                            <div class="asset-title">{{ $asset['name'] ?? $asset['ipAddress'] ?? '—' }}</div>
                            <div class="asset-meta">
                                <span class="mono">{{ $asset['ipAddress'] ?? '—' }}</span>
                                &nbsp;·&nbsp; {{ count($assetOpenPorts) }} open ports
                                &nbsp;·&nbsp; {{ $total }} findings
                            </div>
                        </td>
                        <td style="text-align: right; width: 90px; vertical-align: middle;">
                            <span class="badge badge-{{ strtolower($assetRisk) }}">{{ $assetRisk }}</span>
                        </td>
                    </tr>
                </table>
            </div>

            @if(!empty($assetOpenPorts))
                <div class="asset-body" style="padding-bottom: 4px;">
                    <div class="finding-block-label" style="margin-bottom: 8px;">Open Ports</div>
                    <table class="data-table" style="margin-bottom: 14px;">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Port</th>
                                <th>Description</th>
                                <th style="width: 100px;">Risk</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($assetOpenPorts as $port)
                            @php $portRisk = strtolower($port['riskLevel'] ?? 'unknown'); @endphp
                            <tr>
                                <td class="mono">{{ $port['portNumber'] ?? '—' }}</td>
                                <td>{{ $port['portDescription'] ?? '—' }}</td>
                                <td><span class="badge badge-{{ $portRisk }}">{{ ucfirst($port['riskLevel'] ?? '—') }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(!empty($reportFindings))
                <div class="asset-body" style="padding-top: 4px;">
                    <div class="finding-block-label" style="margin-bottom: 8px;">Vulnerability Findings</div>
                    <table class="data-table" style="margin-bottom: 14px;">
                        <thead>
                            <tr>
                                <th>Flaw</th>
                                <th style="width: 100px;">Risk</th>
                                <th style="width: 110px; text-align: right;">Affected URLs</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($reportFindings as $finding)
                            @php $findingRisk = strtolower($finding['riskLevel'] ?? 'unknown'); @endphp
                            <tr>
                                <td>{{ $finding['name'] ?? '—' }}</td>
                                <td><span class="badge badge-{{ $findingRisk }}">{{ ucfirst($finding['riskLevel'] ?? '—') }}</span></td>
                                <td style="text-align: right;" class="mono">{{ $finding['affectedUrls'] ?? 0 }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @foreach($reportFindings as $finding)
                        @php $findingRisk = strtolower($finding['riskLevel'] ?? 'unknown'); @endphp
                        <div class="finding-card">
                            <div class="finding-card-head">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td>
                                            <div class="finding-title">{{ $finding['name'] ?? '—' }}</div>
                                            <div class="finding-meta">Affected URLs: {{ $finding['affectedUrls'] ?? 0 }}</div>
                                        </td>
                                        <td style="text-align: right; width: 100px; vertical-align: middle;">
                                            <span class="badge badge-{{ $findingRisk }}">{{ ucfirst($finding['riskLevel'] ?? '—') }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="finding-body">
                                @if(!empty($finding['description']))
                                    <div class="finding-block">
                                        <div class="finding-block-label">Description</div>
                                        <div class="finding-block-value">{{ $finding['description'] }}</div>
                                    </div>
                                @endif

                                @if(!empty($finding['solution']))
                                    <div class="finding-block">
                                        <div class="finding-block-label">Solution</div>
                                        <div class="finding-block-value">{{ $finding['solution'] }}</div>
                                    </div>
                                @endif

                                @if(!empty($finding['references']))
                                    <div class="finding-block">
                                        <div class="finding-block-label">References</div>
                                        <div class="finding-block-value">
                                            @foreach($finding['references'] as $reference)
                                                <div class="reference-item mono">{{ $reference }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($finding['instances']))
                                    <div class="finding-block">
                                        <div class="finding-block-label">Evidence Samples</div>
                                        @foreach($finding['instances'] as $instance)
                                            <div class="evidence-sample">
                                                <table class="evidence-table">
                                                    <tr>
                                                        <td class="label">URL</td>
                                                        <td class="value mono">{{ $instance['url'] ?? '—' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Method</td>
                                                        <td class="value mono">{{ $instance['method'] ?? '—' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Attack</td>
                                                        <td class="value">{{ $instance['attack'] ?? '—' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Parameters</td>
                                                        <td class="value">{{ $instance['parameters'] ?? '—' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="label">Evidence</td>
                                                        <td class="value">{{ $instance['evidence'] ?? '—' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="asset-body" style="color: #6b7280; font-size: 10.5px;">No vulnerabilities detected for this asset.</div>
            @endif
        </div>
    @empty
        <div class="panel"><div class="panel-body" style="color: #6b7280; font-size: 10.5px;">No external IP assets available.</div></div>
    @endforelse
</div>

{{-- ==================== Section 04 — Vulnerability Details ==================== --}}
<div class="section" style="page-break-before: always;">
    <div class="section-head">
        <div class="section-eyebrow">04 · Vulnerabilities</div>
        <div class="section-title">Vulnerability Details</div>
    </div>
    <div class="section-rule"></div>

    @forelse($cveItems ?? [] as $cve)
        @php $cveRisk = strtolower($cve['cve_risk'] ?? 'unknown'); @endphp
        <div class="panel">
            <table class="kv-table">
                <tr>
                    <td class="label">Severity</td>
                    <td class="value"><span class="badge badge-{{ $cveRisk }}">{{ ucfirst($cve['cve_risk'] ?? 'Unknown') }}</span></td>
                </tr>
                <tr>
                    <td class="label">Title</td>
                    <td class="value">{{ $cve['title'] ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">CVE Info</td>
                    <td class="value mono">{{ $cve['id'] ?? $cve['cve_id'] ?? $cve['cve_name'] ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Score</td>
                    <td class="value mono">{{ $cve['cve_score'] ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Published</td>
                    <td class="value">{{ $cve['published_date'] ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Affected Targets</td>
                    <td class="value">
                        {{ $cve['affected_targets'] ?? '—' }}
                        @if(!empty($cve['num_affected_targets']))
                            <span style="color: #9ca3af;">({{ $cve['num_affected_targets'] }})</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    @empty
        <div class="panel"><div class="panel-body" style="color: #6b7280; font-size: 10.5px;">No CVE data available.</div></div>
    @endforelse
</div>

{{-- ==================== Section 05 — Open Ports Summary ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">05 · Network</div>
        <div class="section-title">Open Ports Summary</div>
    </div>
    <div class="section-rule"></div>
    <div class="panel">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Port</th>
                    <th>Description</th>
                    <th style="width: 100px;">Risk</th>
                    <th style="width: 120px; text-align: right;">Machines</th>
                </tr>
            </thead>
            <tbody>
                @forelse($openPorts ?? [] as $port)
                    @php $portRisk = strtolower($port['riskLevel'] ?? 'unknown'); @endphp
                    <tr>
                        <td class="mono">{{ $port['portNumber'] ?? '—' }}</td>
                        <td>{{ $port['portDescription'] ?? '—' }}</td>
                        <td><span class="badge badge-{{ $portRisk }}">{{ ucfirst($port['riskLevel'] ?? '—') }}</span></td>
                        <td style="text-align: right;" class="mono">{{ $port['machineCount'] ?? '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="color: #6b7280;">No open port data available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
