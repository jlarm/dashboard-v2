<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Executive Scan Report</title>
    @include('tenant.scans.reports._fonts')
    @include('tenant.scans.reports._styles')
</head>
<body>
@php
    $scanDate = $externalScanInfo['scan_finished'] ?? null;
    $scannedIps = collect($externalAssets ?? [])->pluck('ipAddress')->filter()->unique()->implode(', ');

    $formattedScanDate = null;
    if ($scanDate) {
        try {
            $formattedScanDate = \Carbon\Carbon::parse($scanDate)->format('M j, Y · H:i') . ' UTC';
        } catch (\Exception $e) {
            $formattedScanDate = $scanDate;
        }
    }

    $assessmentDate = null;
    try {
        $assessmentDate = $scanDate ? \Carbon\Carbon::parse($scanDate)->format('M j, Y') : now()->format('M j, Y');
    } catch (\Exception $e) {
        $assessmentDate = now()->format('M j, Y');
    }
    $reportingDate = now()->format('M j, Y');

    $metaRows = [
        ['label' => 'Assessment Period', 'value' => $assessmentDate],
        ['label' => 'Reporting Date', 'value' => $reportingDate],
    ];
@endphp

@include('tenant.scans.reports._cover', ['reportType' => 'Executive', 'storeName' => $storeName, 'metaRows' => $metaRows])

{{-- ==================== Section 01 — Scan Details ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">01 · Engagement</div>
        <div class="section-title">Scan Details</div>
    </div>
    <div class="section-rule"></div>
    <div class="panel">
        <table class="kv-table">
            <tr>
                <td class="label">Scan Date</td>
                <td class="value">{{ $formattedScanDate ?? ($lastScanDate ?? '—') }}</td>
            </tr>
            <tr>
                <td class="label">Scanned IPs</td>
                <td class="value mono">{{ $scannedIps ?: '—' }}</td>
            </tr>
        </table>
    </div>
</div>

{{-- ==================== Section 02 — Risk Rating Reference ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">02 · Reference</div>
        <div class="section-title">Vulnerability Risk Rating</div>
        <div class="section-sub">Severity classifications applied throughout this report.</div>
    </div>
    <div class="section-rule"></div>
    <div class="panel">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Severity</th>
                    <th>Definition</th>
                    <th style="width: 120px;">CVSS Score</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="badge badge-critical">Critical</span></td>
                    <td>Vulnerabilities that pose a significant risk and could lead to system compromise or unauthorized access.</td>
                    <td class="mono">9.0 – 10.0</td>
                </tr>
                <tr>
                    <td><span class="badge badge-high">High</span></td>
                    <td>Vulnerabilities with substantial impact on system or application security; address urgently.</td>
                    <td class="mono">7.0 – 8.9</td>
                </tr>
                <tr>
                    <td><span class="badge badge-medium">Medium</span></td>
                    <td>Vulnerabilities with moderate impact requiring timely attention.</td>
                    <td class="mono">4.0 – 6.9</td>
                </tr>
                <tr>
                    <td><span class="badge badge-low">Low</span></td>
                    <td>Minor vulnerabilities with limited security impact; should still be remediated.</td>
                    <td class="mono">0.0 – 3.9</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== Section 03 — Overall Risk Assessment ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">03 · Posture</div>
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

{{-- ==================== Section 04 — Issue Summary ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">04 · Summary</div>
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

{{-- ==================== Section 05 — External IP Attack Surface ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">05 · Attack Surface</div>
        <div class="section-title">External IP Attack Surface</div>
        <div class="section-sub">External scan assets and their associated risk level.</div>
    </div>
    <div class="section-rule"></div>
    @forelse($externalAssets ?? [] as $asset)
        @php
            $assetVulns = $asset['vulnerabilities'] ?? [];
            $assetPorts = $asset['openPorts'] ?? [];
            $assetRisk = 'Clean';
            foreach ($assetVulns as $v) {
                $r = strtolower($v['riskLevel'] ?? '');
                if ($r === 'critical') { $assetRisk = 'Critical'; break; }
                if ($r === 'high') { $assetRisk = 'High'; }
                if ($r === 'medium' && !in_array($assetRisk, ['High', 'Critical'])) { $assetRisk = 'Medium'; }
                if ($r === 'low' && $assetRisk === 'Clean') { $assetRisk = 'Low'; }
            }
        @endphp
        <div class="asset-card">
            <div class="asset-head">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td>
                            <div class="asset-title">{{ $asset['name'] ?? $asset['ipAddress'] ?? '—' }}</div>
                            <div class="asset-meta">
                                <span class="mono">{{ $asset['ipAddress'] ?? '—' }}</span>
                                &nbsp;·&nbsp; {{ count($assetPorts) }} open ports
                            </div>
                        </td>
                        <td style="text-align: right; width: 90px; vertical-align: middle;">
                            <span class="badge badge-{{ strtolower($assetRisk) }}">{{ $assetRisk }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @empty
        <div class="panel"><div class="panel-body" style="color: #6b7280; font-size: 10.5px;">No external assets available.</div></div>
    @endforelse
</div>

{{-- ==================== Section 06 — Security Vulnerabilities ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">06 · Findings</div>
        <div class="section-title">Security Vulnerabilities</div>
    </div>
    <div class="section-rule"></div>
    <div class="panel">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Identifier</th>
                    <th style="width: 110px;">Severity</th>
                </tr>
            </thead>
            <tbody>
            @forelse($cveItems ?? [] as $cve)
                @php $cveRisk = strtolower($cve['cve_risk'] ?? 'unknown'); @endphp
                <tr>
                    <td class="mono">{{ $cve['id'] ?? $cve['cve_id'] ?? $cve['cve_name'] ?? '—' }}</td>
                    <td><span class="badge badge-{{ $cveRisk }}">{{ ucfirst($cve['cve_risk'] ?? 'Unknown') }}</span></td>
                </tr>
            @empty
                <tr><td colspan="2" style="color: #6b7280;">No security vulnerabilities found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ==================== Section 07 — Open Ports ==================== --}}
<div class="section">
    <div class="section-head">
        <div class="section-eyebrow">07 · Network</div>
        <div class="section-title">Open Port Vulnerabilities</div>
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
