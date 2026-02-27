<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Technical Scan Report</title>
    <style>
        @page { margin: 48px 56px; }
        * {
            box-sizing: border-box;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .page {}
        .page-break { page-break-after: always; }

        .section {
            page-break-inside: auto;
            margin-bottom: 28px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 16px;
            page-break-inside: auto;
        }

        .section-heading {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .sub-heading {
            font-size: 16px;
            font-weight: 700;
            color: #006c98;
        }

        .details-table { width: 100%; border-collapse: collapse; }
        .details-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .details-table tr:last-child td { border-bottom: none; }
        .details-table .label { color: #374151; font-weight: 600; width: 200px; }
        .details-table .value { color: #374151; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            padding: 10px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }
        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
            color: #374151;
        }
        .data-table tr:last-child td { border-bottom: none; }

        .finding-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 12px;
            page-break-inside: auto;
        }
        .finding-card-header {
            width: 100%;
            border-collapse: collapse;
            background: #f9fafb;
            page-break-after: avoid;
        }
        .finding-card-header td {
            padding: 12px 14px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }
        .finding-title {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }
        .finding-meta {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }
        .finding-body {
            padding: 14px;
            page-break-inside: auto;
        }
        .finding-block {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        .finding-block-breakable {
            page-break-inside: auto;
        }
        .finding-block:last-child {
            margin-bottom: 0;
        }
        .finding-block-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .finding-block-value {
            font-size: 11px;
            color: #374151;
            line-height: 1.6;
            white-space: pre-line;
        }
        .reference-item {
            font-size: 10px;
            color: #374151;
            margin-bottom: 3px;
            word-break: break-word;
        }
        .compact-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .compact-table th {
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            background: #f9fafb;
        }
        .compact-table td {
            padding: 9px 10px;
            font-size: 10px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
            word-break: break-word;
        }
        .compact-table tr:last-child td {
            border-bottom: none;
        }
        .evidence-sample {
            margin-top: 10px;
            border: 1px solid #dbe1e8;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
            background: #ffffff;
        }
        .evidence-sample:first-child {
            margin-top: 0;
        }
        .evidence-sample-table {
            width: 100%;
            border-collapse: collapse;
        }
        .evidence-sample-title {
            width: 130px;
            padding: 14px 12px;
            background: #f9fafb;
            color: #374151;
            font-size: 11px;
            font-weight: 700;
            border-right: 1px solid #e8edf3;
            vertical-align: top;
        }
        .evidence-sample-content {
            padding: 0;
            vertical-align: top;
        }
        .evidence-sample-details {
            width: 100%;
            border-collapse: collapse;
        }
        .evidence-sample-label {
            width: 110px;
            padding: 9px 12px;
            background: #fcfcfd;
            color: #4b5563;
            font-size: 10px;
            font-weight: 700;
            border-right: 1px solid #eef2f7;
            border-bottom: 1px solid #eef2f7;
        }
        .evidence-sample-value {
            padding: 9px 12px;
            color: #374151;
            font-size: 10px;
            line-height: 1.55;
            word-break: break-word;
            white-space: pre-line;
            border-bottom: 1px solid #eef2f7;
        }
        .evidence-sample-details tr:last-child .evidence-sample-label,
        .evidence-sample-details tr:last-child .evidence-sample-value {
            border-bottom: none;
        }

        .badge-colors-critical { color: #92400e; background: #fffbeb; }
        .badge-colors-high { color: #991b1b; background: #fef2f2; }
        .badge-colors-medium { color: #854d0e; background: #fefce8; }
        .badge-colors-low { color: #166534; background: #f0fdf4; }
        .badge-colors-clean { color: #166534; background: #f0fdf4; }
    </style>
</head>
<body>

    {{-- ==================== PAGE 1: COVER ==================== --}}
    @php
        $lightSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 247.36 215.95"><path d="M110.5 215.95H0L122.92 0l18.65 32.36-87.72 152.18H90.87l32.05-55.53 18.99 30.85-31.41 56.09z" fill="#b8d8e8"/><path d="m141.91 97.29 18.76-31.66 17.24 29.88-17.95 32.08-18.05-30.3z" fill="#cde0b4"/><path d="m212.58 215.95-37.11-62.31 18.09-30.98 53.8 93.29h-34.78z" fill="#f9d4a8"/></svg>';
        $svgDataUri = 'data:image/svg+xml;base64,' . base64_encode($lightSvg);
    @endphp
    <div class="page-break" style="padding: 12px 8px; position: relative;">
        <img src="{{ $svgDataUri }}" style="position: absolute; top: 400px; left: 84px; width: 840px; height: auto; z-index: -1;" />

        <div style="text-align: center; margin-bottom: 48px;">
            <img src="{{ public_path('armp-rb-logo.png') }}" style="width: 280px; height: auto;" />
        </div>
        <div style="text-align: center;">
            <div style="font-size: 22px; color: #006c98; font-weight: bold;">Technical Report</div>
        </div>
        <div style="text-align: center; margin-top: 64px;">
            <div style="font-size: 13px; color: #9ca3af;">Prepared for</div>
            <div style="font-size: 20px; font-weight: 700; color: #111827;">{{ $storeName }}</div>
        </div>
        <div style="margin-top: 120px; text-align: center;">
            <table style="border-collapse: collapse; margin: 0 auto;">
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #000000; width: 220px;">Generated</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $generatedAt }}</td>
                </tr>
                @if($lastScanDate)
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #000000;">Last Scan</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $lastScanDate }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    {{-- ==================== CONTENT PAGES (single flowing container) ==================== --}}
    <div class="page">

        {{-- Overall Risk Assessment --}}
        <div class="section">
            <div style="margin-bottom: 4px;">
                <div class="sub-heading" style="margin-bottom: 2px;">Overall Risk Assessment</div>
                <div style="font-size: 11px; color: #6b7280;">Current security posture across all scan types</div>
            </div>
            <table style="width: 100%; border-collapse: separate; border-spacing: 12px 0; margin-top: 12px;">
                <tr>
                    <td style="width: 50%; vertical-align: top; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px;">
                        <div style="font-size: 11px; color: #6b7280;">Overall Risk</div>
                        <div style="font-size: 24px; font-weight: 700; color: #111827; margin-top: 4px;">{{ $overall['current_or_grade'] ?? '-' }}</div>
                        <div style="font-size: 10px; color: #9ca3af; margin-top: 2px;">Previous: {{ $overall['previous_or_grade'] ?? '-' }}</div>
                    </td>
                    <td style="width: 50%; vertical-align: top; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px;">
                        <div style="font-size: 11px; color: #6b7280;">Vulnerabilities</div>
                        <div style="font-size: 24px; font-weight: 700; color: #111827; margin-top: 4px;">{{ $overall['current_vn_grade'] ?? '-' }}</div>
                        <div style="font-size: 10px; color: #9ca3af; margin-top: 2px;">Previous: {{ $overall['previous_vn_grade'] ?? '-' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Issue Summary --}}
        <div class="section">
            <table style="width: 100%; border-collapse: separate; border-spacing: 8px 0;">
                <tr>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">Issues</div>
                        <div style="font-size: 22px; font-weight: 700; color: #111827;">{{ $issueCounts['vulnerabilities'] ?? '-' }}</div>
                    </td>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">Critical</div>
                        <div style="font-size: 22px; font-weight: 700; color: #22c55e;">{{ $issueCounts['critical_vulnerabilities'] ?? '-' }}</div>
                    </td>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">High</div>
                        <div style="font-size: 22px; font-weight: 700; color: #ef4444;">{{ $issueCounts['high_vulnerabilities'] ?? '-' }}</div>
                    </td>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">Medium</div>
                        <div style="font-size: 22px; font-weight: 700; color: #eab308;">{{ $issueCounts['medium_vulnerabilities'] ?? '-' }}</div>
                    </td>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">Low</div>
                        <div style="font-size: 22px; font-weight: 700; color: #22c55e;">{{ $issueCounts['low_vulnerabilities'] ?? '-' }}</div>
                    </td>
                    <td style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 12px 14px; text-align: left;">
                        <div style="font-size: 10px; color: #6b7280; margin-bottom: 4px;">Grade</div>
                        <div style="font-size: 22px; font-weight: 700; color: #111827;">{{ $issueCounts['grade_alpha'] ?? '-' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- External IP Attack Surface --}}
        <div style="margin-bottom: 28px;">
            <div style="margin-bottom: 12px;">
                <div class="sub-heading" style="margin-bottom: 2px;">External IP Attack Surface</div>
                <div style="font-size: 11px; color: #6b7280;">
                    Last scanned: {{ $externalScanInfo['scan_finished'] ?? '-' }} &middot;
                    {{ isset($externalAssets) ? count($externalAssets) : 0 }} external assets
                </div>
            </div>

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
                <div style="margin-bottom: 24px;">
                    <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                        <tr>
                            <td style="vertical-align: middle;">
                                <div style="font-size: 13px; font-weight: 700; color: #111827;">{{ $asset['name'] ?? $asset['ipAddress'] ?? '-' }}</div>
                                <div style="font-size: 11px; color: #6b7280; margin-top: 2px;">
                                    {{ $asset['ipAddress'] ?? '-' }}
                                    <span style="color: #d1d5db; margin: 0 4px;">|</span>
                                    {{ count($assetOpenPorts) }} open ports
                                    <span style="color: #d1d5db; margin: 0 4px;">|</span>
                                    {{ $total }} findings
                                </div>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <table style="border-collapse: collapse; margin-left: auto;"><tr><td class="badge-colors-{{ strtolower($assetRisk) }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px; text-transform: uppercase;">{{ $assetRisk }}</td></tr></table>
                            </td>
                        </tr>
                    </table>

                    @if(!empty($assetOpenPorts))
                        <div style="margin-bottom: 12px;">
                            <div style="font-size: 11px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">Open Ports</div>
                            @foreach($assetOpenPorts as $port)
                                @php $portRisk = strtolower($port['riskLevel'] ?? 'low'); @endphp
                                <div style="border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 8px; page-break-inside: avoid;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <tr>
                                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; width: 160px; font-size: 11px;">Port</td>
                                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $port['portNumber'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; font-size: 11px;">Description</td>
                                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $port['portDescription'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 10px 14px; color: #374151; font-weight: 600; font-size: 11px;">Risk</td>
                                            <td style="padding: 10px 14px;">
                                                <table style="border-collapse: collapse;"><tr><td class="badge-colors-{{ $portRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; padding: 2px 10px; text-transform: uppercase;">{{ ucfirst($port['riskLevel'] ?? '-') }}</td></tr></table>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(!empty($reportFindings))
                        <div>
                            <div style="font-size: 11px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">Vulnerability Findings</div>
                            <table class="data-table" style="margin-bottom: 12px;">
                                <thead>
                                    <tr>
                                        <th style="width: 56%;">Flaw</th>
                                        <th style="width: 20%;">Risk Level</th>
                                        <th style="width: 24%; text-align: right;">Affected URLs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportFindings as $finding)
                                        @php $findingRisk = strtolower($finding['riskLevel'] ?? 'low'); @endphp
                                        <tr style="page-break-inside: avoid;">
                                            <td>{{ $finding['name'] ?? '-' }}</td>
                                            <td>
                                                <table style="border-collapse: collapse;"><tr><td class="badge-colors-{{ $findingRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; padding: 2px 10px; text-transform: uppercase;">{{ ucfirst($finding['riskLevel'] ?? '-') }}</td></tr></table>
                                            </td>
                                            <td style="text-align: right;">{{ $finding['affectedUrls'] ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @foreach($reportFindings as $finding)
                                @php $findingRisk = strtolower($finding['riskLevel'] ?? 'low'); @endphp
                                <div class="finding-card">
                                    <table class="finding-card-header">
                                        <tr>
                                            <td>
                                                <div class="finding-title">{{ $finding['name'] ?? '-' }}</div>
                                                <div class="finding-meta">Affected URLs: {{ $finding['affectedUrls'] ?? 0 }}</div>
                                            </td>
                                            <td style="width: 110px; text-align: right;">
                                                <table style="border-collapse: collapse;"><tr><td class="badge-colors-{{ $findingRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; padding: 2px 10px; text-transform: uppercase;">{{ ucfirst($finding['riskLevel'] ?? '-') }}</td></tr></table>
                                            </td>
                                        </tr>
                                    </table>

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
                                                        <div class="reference-item">{{ $reference }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($finding['instances']))
                                            <div class="finding-block finding-block-breakable">
                                                <div class="finding-block-label">Evidence Samples</div>
                                                @foreach($finding['instances'] as $instance)
                                                    <div class="evidence-sample">
                                                        <table class="evidence-sample-table">
                                                            <tr>
                                                                <td class="evidence-sample-title">Evidence Sample</td>
                                                                <td class="evidence-sample-content">
                                                                    <table class="evidence-sample-details">
                                                                        <tr>
                                                                            <td class="evidence-sample-label">URL</td>
                                                                            <td class="evidence-sample-value">{{ $instance['url'] ?? '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="evidence-sample-label">Method</td>
                                                                            <td class="evidence-sample-value">{{ $instance['method'] ?? '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="evidence-sample-label">Attack</td>
                                                                            <td class="evidence-sample-value">{{ $instance['attack'] ?? '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="evidence-sample-label">Parameters</td>
                                                                            <td class="evidence-sample-value">{{ $instance['parameters'] ?? '-' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="evidence-sample-label">Evidence</td>
                                                                            <td class="evidence-sample-value">{{ $instance['evidence'] ?? '-' }}</td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
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
                        <div style="color: #6b7280; font-size: 11px;">No vulnerabilities detected for this asset.</div>
                    @endif
                </div>
            @empty
                <div style="color: #6b7280; font-size: 11px; padding: 12px 0;">No external IP assets available.</div>
            @endforelse
        </div>

        {{-- Vulnerability Details --}}
        <div style="margin-bottom: 28px; page-break-before: always;">
            <div style="margin-bottom: 12px;">
                <div class="sub-heading">Vulnerability Details</div>
            </div>
            @forelse($cveItems ?? [] as $cve)
                @php $cveRisk = strtolower($cve['cve_risk'] ?? 'low'); @endphp
                <div style="border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 10px; page-break-inside: avoid;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; width: 160px; font-size: 11px;">Severity</td>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6;">
                                <table style="border-collapse: collapse;"><tr><td class="badge-colors-{{ $cveRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; padding: 2px 10px; text-transform: uppercase;">{{ ucfirst($cve['cve_risk'] ?? 'Unknown') }}</td></tr></table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; font-size: 11px;">Title</td>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $cve['title'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; font-size: 11px;">CVE Info</td>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $cve['id'] ?? $cve['cve_id'] ?? $cve['cve_name'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; font-size: 11px;">Score</td>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $cve['cve_score'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-weight: 600; font-size: 11px;">Published Date</td>
                            <td style="padding: 10px 14px; border-bottom: 1px solid #f3f4f6; color: #374151; font-size: 11px;">{{ $cve['published_date'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 14px; color: #374151; font-weight: 600; font-size: 11px;">Affected Targets</td>
                            <td style="padding: 10px 14px; color: #374151; font-size: 11px;">
                                {{ $cve['affected_targets'] ?? '-' }}
                                @if(!empty($cve['num_affected_targets']))
                                    <span style="color: #9ca3af;">({{ $cve['num_affected_targets'] }})</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            @empty
                <div style="color: #6b7280; font-size: 11px; padding: 12px 0;">No CVE data available.</div>
            @endforelse
        </div>

        {{-- Open Ports Summary --}}
        <div class="section">
            <div class="card" style="padding: 24px;">
                <div class="section-heading">Open Ports Summary</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 12%;">Port</th>
                            <th style="width: 43%;">Description</th>
                            <th style="width: 22%;">Risk Level</th>
                            <th style="width: 23%; text-align: right;">No. of Machines</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($openPorts ?? [] as $port)
                            @php $portRisk = strtolower($port['riskLevel'] ?? 'low'); @endphp
                            <tr style="page-break-inside: avoid;">
                                <td>{{ $port['portNumber'] ?? '-' }}</td>
                                <td>{{ $port['portDescription'] ?? '-' }}</td>
                                <td>
                                    <table style="border-collapse: collapse;"><tr><td class="badge-colors-{{ $portRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px; text-transform: uppercase;">{{ strtoupper($port['riskLevel'] ?? '-') }}</td></tr></table>
                                </td>
                                <td style="text-align: right;">{{ $port['machineCount'] ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="color: #6b7280;">No open port data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>{{-- end single .page wrapper --}}

</body>
</html>
