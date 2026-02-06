<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Executive Scan Report</title>
    <style>
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            src: url('https://fonts.gstatic.com/s/inter/v20/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuLyfMZg.ttf') format('truetype');
        }
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            src: url('https://fonts.gstatic.com/s/inter/v20/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuGKYMZg.ttf') format('truetype');
        }
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 700;
            src: url('https://fonts.gstatic.com/s/inter/v20/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuFuYMZg.ttf') format('truetype');
        }
        @page { margin: 0; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', DejaVu Sans, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .page { padding: 48px 56px; }
        .page-break { page-break-after: always; }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px 24px;
            margin-bottom: 16px;
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
    <div class="page-break" style="padding: 60px 64px;">
        <div style="margin-bottom: 48px;">
            <img src="{{ public_path('armp-rb-logo.png') }}" style="width: 280px; height: auto;" />
        </div>

        <div>
            <div style="font-size: 22px; color: #9ca3af;">Executive Report</div>
        </div>

        <div style="margin-top: 64px;">
            <div style="font-size: 13px; color: #9ca3af;">Prepared for</div>
            <div style="font-size: 20px; font-weight: 700; color: #111827; margin-top: 4px;">{{ $storeName }}</div>
        </div>

        <div style="margin-top: 320px;">
            <table style="border-collapse: collapse;">
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #006c98; width: 220px;">Assessment Period</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $assessmentDate }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; font-size: 14px; font-weight: 700; color: #006c98;">Reporting Date</td>
                    <td style="padding: 10px 0; font-size: 14px; color: #374151;">{{ $reportingDate }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ==================== PAGE 2: INTRODUCTION ==================== --}}
    <div class="page page-break">
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

        <div style="margin-top: 28px; margin-bottom: 16px;">
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

    {{-- ==================== PAGE 3: OVERALL RISK + ISSUE SUMMARY ==================== --}}
    <div class="page page-break">
        {{-- Overall Risk Assessment --}}
        <div>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 4px;">
                <tr>
                    <td style="vertical-align: top;">
                        <div style="font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 2px;">Overall Risk Assessment</div>
                        <div style="font-size: 11px; color: #6b7280;">Current security posture across all scan types</div>
                    </td>
                </tr>
            </table>

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
        <table style="width: 100%; border-collapse: separate; border-spacing: 8px 0; margin-top: 8px;">
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

    {{-- ==================== PAGE 4: EXTERNAL IP ATTACK SURFACE ==================== --}}
    <div class="page page-break">
        <div>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                <tr>
                    <td style="vertical-align: top;">
                        <div class="section-heading" style="margin-bottom: 2px;">External IP Attack Surface</div>
                        <div style="font-size: 11px; color: #6b7280;">External scan assets and their vulnerabilities</div>
                    </td>
                </tr>
            </table>

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
                    $riskClass = 'risk-' . strtolower($assetRisk);
                @endphp
                <div style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px; margin-bottom: 8px;">
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
    </div>

    {{-- ==================== PAGE 5: SECURITY VULNERABILITIES ==================== --}}
    <div class="page page-break">
        <div class="card" style="padding: 24px;">
            <div class="section-heading">Security Vulnerabilities</div>

            @forelse($cveItems ?? [] as $cve)
                @php
                    $cveRisk = strtolower($cve['cve_risk'] ?? 'low');
                    $riskClass = 'risk-' . $cveRisk;
                @endphp
                <div style="border-bottom: 1px solid #f3f4f6; padding: 10px 0;">
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

    {{-- ==================== PAGE 6: OPEN PORT VULNERABILITIES ==================== --}}
    <div class="page">
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
                        <tr>
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
</body>
</html>
