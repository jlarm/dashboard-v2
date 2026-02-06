<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Technical Scan Report</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #111827; font-size: 12px; margin: 0; }
        .page { padding: 28px 32px; }
        .header { border-bottom: 2px solid #e5e7eb; padding-bottom: 12px; margin-bottom: 18px; }
        .title { font-size: 20px; font-weight: 700; margin: 0 0 4px; }
        .subtitle { color: #6b7280; margin: 0; }
        .meta { margin-top: 8px; color: #6b7280; font-size: 11px; }
        .section-title { margin: 18px 0 8px; font-size: 13px; font-weight: 700; color: #111827; }
        .grid { display: table; width: 100%; margin-top: 16px; }
        .row { display: table-row; }
        .cell { display: table-cell; padding: 8px; vertical-align: top; }
        .card { border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px; }
        .card h3 { margin: 0 0 6px; font-size: 12px; color: #374151; text-transform: uppercase; letter-spacing: .04em; }
        .value { font-size: 22px; font-weight: 700; color: #111827; }
        .muted { color: #6b7280; font-size: 11px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 6px 8px; text-align: left; vertical-align: top; }
        .table th { background: #f9fafb; font-size: 11px; text-transform: uppercase; letter-spacing: .04em; color: #374151; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 10px; background: #eef2ff; color: #3730a3; font-size: 10px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1 class="title">Technical Scan Report</h1>
            <p class="subtitle">{{ $storeName }}</p>
            <div class="meta">Generated {{ $generatedAt }}@if($lastScanDate) · Last scan {{ $lastScanDate }}@endif</div>
        </div>

        <div class="grid">
            <div class="row">
                <div class="cell" style="width: 50%;">
                    <div class="card">
                        <h3>Overall Risk</h3>
                        <div class="value">{{ $overall['current_or_grade'] ?? '-' }}</div>
                        <div class="muted">Previous: {{ $overall['previous_or_grade'] ?? '-' }}</div>
                    </div>
                </div>
                <div class="cell" style="width: 50%;">
                    <div class="card">
                        <h3>Vulnerability Grade</h3>
                        <div class="value">{{ $overall['current_vn_grade'] ?? '-' }}</div>
                        <div class="muted">Previous: {{ $overall['previous_vn_grade'] ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-title">Issue Summary</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Issues</th>
                    <th>Critical</th>
                    <th>High</th>
                    <th>Medium</th>
                    <th>Low</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $issueCounts['vulnerabilities'] ?? '-' }}</td>
                    <td>{{ $issueCounts['critical_vulnerabilities'] ?? '-' }}</td>
                    <td>{{ $issueCounts['high_vulnerabilities'] ?? '-' }}</td>
                    <td>{{ $issueCounts['medium_vulnerabilities'] ?? '-' }}</td>
                    <td>{{ $issueCounts['low_vulnerabilities'] ?? '-' }}</td>
                    <td><span class="badge">{{ $issueCounts['grade_alpha'] ?? '-' }}</span></td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">External IP Attack Surface</div>
        <div class="muted" style="margin-bottom: 8px;">
            Last scanned: {{ $externalScanInfo['scan_finished'] ?? '-' }} ·
            {{ isset($externalAssets) ? count($externalAssets) : 0 }} external assets
        </div>
        @forelse($externalAssets ?? [] as $asset)
            @php
                $openPorts = $asset['openPorts'] ?? [];
                $vulnerabilities = $asset['vulnerabilities'] ?? [];
                $critical = 0; $high = 0; $medium = 0; $low = 0;
                foreach ($vulnerabilities as $vuln) {
                    $riskLevel = strtolower($vuln['riskLevel'] ?? '');
                    if ($riskLevel === 'critical') { $critical++; }
                    elseif ($riskLevel === 'high') { $high++; }
                    elseif ($riskLevel === 'medium') { $medium++; }
                    elseif ($riskLevel === 'low') { $low++; }
                }
                $total = $critical + $high + $medium + $low;
            @endphp
            <div class="card" style="margin-bottom: 12px;">
                <h3>{{ $asset['name'] ?? $asset['ipAddress'] ?? 'Unknown Asset' }} · {{ $asset['ipAddress'] ?? '-' }}</h3>
                <div class="muted" style="margin-top: 4px;">
                    {{ count($openPorts) }} open ports · {{ $total }} vulnerabilities
                </div>

                @if(!empty($openPorts))
                    <div style="margin-top: 8px;">
                        <div class="muted" style="margin-bottom: 4px;">Open Ports ({{ count($openPorts) }})</div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 20%;">Port</th>
                                    <th style="width: 55%;">Description</th>
                                    <th style="width: 25%;">Risk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($openPorts as $port)
                                    <tr>
                                        <td>{{ $port['portNumber'] ?? '-' }}</td>
                                        <td>{{ $port['portDescription'] ?? '-' }}</td>
                                        <td>{{ ucfirst($port['riskLevel'] ?? 'Unknown') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div style="margin-top: 10px;">
                    <div class="muted" style="margin-bottom: 4px;">Vulnerabilities</div>
                    @if(!empty($vulnerabilities))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">CVE</th>
                                    <th style="width: 45%;">Title</th>
                                    <th style="width: 15%;">Risk</th>
                                    <th style="width: 15%;">Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vulnerabilities as $vuln)
                                    <tr>
                                        <td>{{ $vuln['cve'] ?? 'Unknown CVE' }}</td>
                                        <td>{{ $vuln['title'] ?? '-' }}</td>
                                        <td>{{ ucfirst($vuln['riskLevel'] ?? 'Unknown') }}</td>
                                        <td>{{ $vuln['score'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="muted">No vulnerabilities detected for this asset.</div>
                    @endif
                </div>
            </div>
        @empty
            <div class="muted">No external IP assets available.</div>
        @endforelse

        <div class="section-title">Vulnerability Details</div>
        @forelse($cveItems ?? [] as $cve)
            <div class="card" style="margin-bottom: 10px;">
                <h3>{{ $cve['id'] ?? $cve['cve_id'] ?? $cve['cve_name'] ?? '-' }}</h3>
                <div class="muted" style="margin-top: 4px;">Risk: {{ $cve['cve_risk'] ?? '-' }} · Score: {{ $cve['cve_score'] ?? '-' }}</div>
                <div style="margin-top: 6px;">{{ $cve['title'] ?? '-' }}</div>
                <div class="muted" style="margin-top: 6px;">
                    Published: {{ $cve['published_date'] ?? '-' }} ·
                    Affected Targets: {{ $cve['affected_targets'] ?? '-' }} ·
                    Number of Targets: {{ $cve['num_affected_targets'] ?? '-' }}
                </div>
            </div>
        @empty
            <div class="muted">No CVE data available.</div>
        @endforelse

        <div class="section-title">Open Ports Summary</div>
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 20%;">Port</th>
                    <th style="width: 45%;">Description</th>
                    <th style="width: 20%;">Risk</th>
                    <th style="width: 15%;">Machines</th>
                </tr>
            </thead>
            <tbody>
                @forelse($openPorts ?? [] as $port)
                    <tr>
                        <td>{{ $port['portNumber'] ?? '-' }}</td>
                        <td>{{ $port['portDescription'] ?? '-' }}</td>
                        <td>{{ $port['riskLevel'] ?? '-' }}</td>
                        <td>{{ $port['machineCount'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No open port data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
