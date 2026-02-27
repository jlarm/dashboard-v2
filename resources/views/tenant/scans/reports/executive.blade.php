<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Executive Scan Report</title>
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
            page-break-inside: avoid;
            margin-bottom: 28px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 16px;
            page-break-inside: avoid;
        }

        .section-heading {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }
        .section-icon {
            display: inline-block;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 14px;
            color: #ffffff;
            vertical-align: middle;
            margin-right: 10px;
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
        .data-table td table td {
            border-bottom: none;
            padding: 2px 8px;
        }

        .badge-colors-critical { color: #92400e; background: #fffbeb; }
        .badge-colors-high { color: #991b1b; background: #fef2f2; }
        .badge-colors-medium { color: #854d0e; background: #fefce8; }
        .badge-colors-low { color: #166534; background: #f0fdf4; }
        .badge-colors-clean { color: #166534; background: #f0fdf4; }

        .risk-desc { color: #374151; font-size: 12px; line-height: 1.6; }
        .risk-cvss { color: #9ca3af; font-size: 11px; margin-top: 4px; }

        .conclusion-text {
            color: #374151;
            font-size: 12px;
            line-height: 1.8;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
@php
    $scanDate = $externalScanInfo['scan_finished'] ?? null;
    $scannedIps = collect($externalAssets ?? [])->pluck('ipAddress')->filter()->unique()->implode(', ');
    $grade = $overall['current_vn_grade'] ?? '-';

    $formattedScanDate = null;
    if ($scanDate) {
        try {
            $formattedScanDate = \Carbon\Carbon::parse($scanDate)->format('m/d/Y H:i:s') . ' UTC';
        } catch (\Exception $e) {
            $formattedScanDate = $scanDate;
        }
    }

    $assessmentDate = null;
    try {
        $assessmentDate = $scanDate ? \Carbon\Carbon::parse($scanDate)->format('m/d/Y') : now()->format('m/d/Y');
    } catch (\Exception $e) {
        $assessmentDate = now()->format('m/d/Y');
    }
    $reportingDate = now()->format('m/d/Y');

    $gradeExplanations = [
        'A' => [
            'summary' => 'This represents a strong vulnerability risk posture, with minimal vulnerabilities across your IT environment.',
            'points' => [
                ['bold' => true, 'text' => 'An "A" vulnerability score indicates excellent security management with very low vulnerability exposure.'],
                ['bold' => false, 'text' => 'The organization maintains strong cyber resilience with minimal security gaps.'],
                ['bold' => false, 'text' => 'Continue monitoring and maintaining your security posture to sustain this excellent rating.'],
            ],
        ],
        'B' => [
            'summary' => 'This represents a moderately strong vulnerability risk posture, with some vulnerabilities remaining present across your IT environment.',
            'points' => [
                ['bold' => true, 'text' => 'A "B" vulnerability score indicates adequate security management but with remaining vulnerability exposure.'],
                ['bold' => false, 'text' => 'The organization maintains reasonable cyber resilience but requires focused attention on closing security gaps.'],
                ['bold' => false, 'text' => 'Continue addressing high-severity vulnerabilities and work downwards to improve overall security hygiene.'],
            ],
        ],
        'C' => [
            'summary' => 'This represents a moderate vulnerability risk posture, with notable vulnerabilities present across your IT environment.',
            'points' => [
                ['bold' => true, 'text' => 'A "C" vulnerability score indicates average security management with significant vulnerability exposure.'],
                ['bold' => false, 'text' => 'The organization has some cyber resilience but with concerning security gaps that need attention.'],
                ['bold' => false, 'text' => 'Prioritize addressing critical and high-severity vulnerabilities immediately to improve your security posture.'],
            ],
        ],
        'D' => [
            'summary' => 'This represents a weak vulnerability risk posture, with significant vulnerabilities present across your IT environment.',
            'points' => [
                ['bold' => true, 'text' => 'A "D" vulnerability score indicates below-average security management with substantial vulnerability exposure.'],
                ['bold' => false, 'text' => 'The organization has limited cyber resilience with major security gaps requiring urgent attention.'],
                ['bold' => false, 'text' => 'Immediate action is required to address critical and high-severity vulnerabilities across your environment.'],
            ],
        ],
        'F' => [
            'summary' => 'This represents a critical vulnerability risk posture requiring immediate attention across your IT environment.',
            'points' => [
                ['bold' => true, 'text' => 'An "F" vulnerability score indicates inadequate security management with severe vulnerability exposure.'],
                ['bold' => false, 'text' => 'The organization has minimal cyber resilience with critical security gaps threatening operations.'],
                ['bold' => false, 'text' => 'Emergency remediation of all critical vulnerabilities is required immediately to protect your organization.'],
            ],
        ],
    ];
    $gradeInfo = $gradeExplanations[$grade] ?? $gradeExplanations['C'];

    $gradeColors = ['A' => '#22c55e', 'B' => '#4338ca', 'C' => '#eab308', 'D' => '#f59e0b', 'F' => '#ef4444'];
    $gradeColor = $gradeColors[$grade] ?? '#4338ca';

    $severityColors = [
        'critical' => '#f59e0b',
        'high' => '#ef4444',
        'medium' => '#eab308',
        'low' => '#22c55e',
    ];
@endphp

    {{-- ==================== PAGE 1: COVER ==================== --}}
    @php
        $lightSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 247.36 215.95"><path d="M110.5 215.95H0L122.92 0l18.65 32.36-87.72 152.18H90.87l32.05-55.53 18.99 30.85-31.41 56.09z" fill="#b8d8e8"/><path d="m141.91 97.29 18.76-31.66 17.24 29.88-17.95 32.08-18.05-30.3z" fill="#cde0b4"/><path d="m212.58 215.95-37.11-62.31 18.09-30.98 53.8 93.29h-34.78z" fill="#f9d4a8"/></svg>';
        $svgDataUri = 'data:image/svg+xml;base64,' . base64_encode($lightSvg);
    @endphp
    <div class="page-break" style="padding: 12px 8px; position: relative;">
        {{-- SVG decoration: 840px wide, halfway off bottom-right --}}
        {{-- SVG aspect: 215.95/247.36 = 0.873, so height ≈ 733px. Half off = top: 960-366=594, left: 704-420=284 --}}
        <img src="{{ $svgDataUri }}" style="position: absolute; top: 400px; left: 84px; width: 840px; height: auto; z-index: -1;" />

        <div style="text-align: center; margin-bottom: 48px;">
            <img src="{{ public_path('armp-rb-logo.png') }}" style="width: 280px; height: auto;" />
        </div>
        <div style="text-align: center;">
            <div style="font-size: 22px; color: #006c98; font-weight: bold;">Executive Report</div>
        </div>
        <div style="text-align: center; margin-top: 64px;">
            <div style="font-size: 13px; color: #9ca3af;">Prepared for</div>
            <div style="font-size: 20px; font-weight: 700; color: #111827;">{{ $storeName }}</div>
        </div>
        <div style="margin-top: 120px; text-align: center;">
            <table style="border-collapse: collapse; margin: 0 auto;">
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #000000; width: 220px;">Assessment Period</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $assessmentDate }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #000000;">Reporting Date</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $reportingDate }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ==================== CONTENT PAGES (single flowing container) ==================== --}}
    <div class="page">

        {{-- Scan Details --}}
        <div class="section">
            <div style="margin-bottom: 16px;">
                <span class="sub-heading">Scan Details</span>
            </div>
            <div class="card">
                <table class="details-table">
                    <tr>
                        <td class="label">Scan Date</td>
                        <td class="value">{{ $formattedScanDate ?? ($lastScanDate ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Scanned IPs</td>
                        <td class="value">{{ $scannedIps ?: '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Vulnerability Risk Rating --}}
        <div class="section">
            <div style="margin-bottom: 16px;">
                <span class="sub-heading">Vulnerability Risk Rating</span>
            </div>
            <div class="card">
                <p style="color: #374151; font-size: 12px; line-height: 1.6; margin: 0 0 4px;">Vulnerabilities are broken down into four categories based on severity.</p>
                <p style="color: #374151; font-size: 12px; line-height: 1.6; margin: 0 0 16px;">Severity levels are categorized as follows:</p>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 12px 0; vertical-align: top; width: 90px;">
                            <table style="border-collapse: collapse;"><tr><td class="badge-colors-critical" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px;">Critical</td></tr></table>
                        </td>
                        <td style="padding: 12px 0 12px 12px; vertical-align: top;">
                            <div class="risk-desc">Vulnerabilities that pose a significant risk and could potentially lead to system compromise or unauthorized access.</div>
                            <div class="risk-cvss">This represents a CVSS Score of 9.0 &ndash; 10.0</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; vertical-align: top;">
                            <table style="border-collapse: collapse;"><tr><td class="badge-colors-high" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px;">High</td></tr></table>
                        </td>
                        <td style="padding: 12px 0 12px 12px; vertical-align: top;">
                            <div class="risk-desc">Vulnerabilities that have a substantial impact on the security of the system or application and should be addressed urgently.</div>
                            <div class="risk-cvss">This represents a CVSS Score of 7.0 &ndash; 8.9</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; vertical-align: top;">
                            <table style="border-collapse: collapse;"><tr><td class="badge-colors-medium" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px;">Medium</td></tr></table>
                        </td>
                        <td style="padding: 12px 0 12px 12px; vertical-align: top;">
                            <div class="risk-desc">Vulnerabilities that have a moderate impact on the security of the system or application and require timely attention.</div>
                            <div class="risk-cvss">This represents a CVSS Score of 4.0 &ndash; 6.9</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 12px 0; vertical-align: top;">
                            <table style="border-collapse: collapse;"><tr><td class="badge-colors-low" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px;">Low</td></tr></table>
                        </td>
                        <td style="padding: 12px 0 12px 12px; vertical-align: top;">
                            <div class="risk-desc">Minor vulnerabilities that have a limited impact on the security of the system or application but should still be remediated.</div>
                            <div class="risk-cvss">This represents a CVSS Score of 0.0 &ndash; 3.9</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

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
        <div class="section">
            <div style="margin-bottom: 12px;">
                <div class="sub-heading" style="margin-bottom: 2px;">External IP Attack Surface</div>
                <div style="font-size: 11px; color: #6b7280;">External scan assets and their vulnerabilities</div>
            </div>
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
                <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px; margin-bottom: 8px; page-break-inside: avoid;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: middle;">
                                <div style="font-size: 12px; font-weight: 700; color: #111827;">{{ $asset['name'] ?? $asset['ipAddress'] ?? '-' }}</div>
                                <div style="font-size: 11px; color: #6b7280; margin-top: 2px;">
                                    {{ $asset['ipAddress'] ?? '-' }}
                                    <span style="color: #d1d5db; margin: 0 4px;">|</span>
                                    {{ count($assetPorts) }} open ports
                                </div>
                            </td>
                            <td style="text-align: right; vertical-align: middle;">
                                <table style="border-collapse: collapse; margin-left: auto;"><tr><td class="badge-colors-{{ strtolower($assetRisk) }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px; text-transform: uppercase;">{{ $assetRisk }}</td></tr></table>
                            </td>
                        </tr>
                    </table>
                </div>
            @empty
                <div style="color: #6b7280; font-size: 11px; padding: 12px 0;">No external assets available.</div>
            @endforelse
        </div>

        {{-- Security Vulnerabilities --}}
        <div class="section">
            <div class="card" style="padding: 24px;">
                <div class="sub-heading">Security Vulnerabilities</div>
                @forelse($cveItems ?? [] as $cve)
                    @php
                        $cveRisk = strtolower($cve['cve_risk'] ?? 'low');
                    @endphp
                    <div style="border-bottom: 1px solid #f3f4f6; padding: 10px 0; page-break-inside: avoid;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="vertical-align: middle;">
                                    <span style="font-size: 12px; font-weight: 600; color: #111827;">{{ $cve['id'] ?? $cve['cve_id'] ?? $cve['cve_name'] ?? '-' }}</span>
                                </td>
                                <td style="text-align: right; vertical-align: middle;">
                                    <table style="border-collapse: collapse; margin-left: auto;"><tr><td class="badge-colors-{{ $cveRisk }}" style="border-radius: 4px; font-size: 9px; font-weight: 700; text-align: center; padding: 2px 8px; text-transform: uppercase;">{{ ucfirst($cve['cve_risk'] ?? 'Unknown') }}</td></tr></table>
                                </td>
                            </tr>
                        </table>
                    </div>
                @empty
                    <div style="color: #6b7280; font-size: 11px; padding: 12px 0;">No security vulnerabilities found.</div>
                @endforelse
            </div>
        </div>

        {{-- Open Port Vulnerabilities --}}
        <div class="section">
            <div class="card" style="padding: 24px;">
                <div class="section-heading">Open Port Vulnerabilities</div>
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
                            <tr style="page-break-inside: avoid;">
                                <td>{{ $port['portNumber'] ?? '-' }}</td>
                                <td>{{ $port['portDescription'] ?? '-' }}</td>
                                <td>
                                    @php $portRisk = strtolower($port['riskLevel'] ?? 'low'); @endphp
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
