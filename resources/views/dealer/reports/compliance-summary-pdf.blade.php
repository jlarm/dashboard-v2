<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compliance Summary — {{ $tenantName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background: #ffffff;
            line-height: 1.5;
        }

        /* ─── Page margins handled by Browsershot .margins() ───────── */

        /* ─── Page-break safety ─────────────────────────────────────── */
        .no-break { page-break-inside: avoid; break-inside: avoid; }
        .break-before { page-break-before: always; break-before: page; }

        /* ─── Logo (white on dark cover) ───────────────────────────── */
        .cover-logo { width: 180px; margin-bottom: 28px; }
        .cover-logo svg path,
        .cover-logo svg .cls-1 { fill: #ffffff !important; }

        /* ─── Cover ─────────────────────────────────────────────────── */
        .cover {
            background: #0f2744;
            color: #ffffff;
            padding: 48px 56px 48px;
            margin-bottom: 36px;
        }
        .cover-eyebrow {
            font-size: 10px; font-weight: 600; letter-spacing: 0.12em;
            text-transform: uppercase; color: #93c5fd; margin-bottom: 8px;
        }
        .cover-title {
            font-size: 28px; font-weight: 800; letter-spacing: -0.02em;
            line-height: 1.2; margin-bottom: 4px;
        }
        .cover-subtitle { font-size: 15px; font-weight: 400; color: #93c5fd; }
        .cover-meta { margin-top: 24px; display: flex; gap: 32px; }
        .cover-meta-item { display: flex; flex-direction: column; gap: 2px; }
        .cover-meta-label {
            font-size: 10px; font-weight: 600; letter-spacing: 0.08em;
            text-transform: uppercase; color: #64a9f7;
        }
        .cover-meta-value { font-size: 13px; font-weight: 500; color: #e2e8f0; }

        /* ─── Body ──────────────────────────────────────────────────── */
        .body { padding-top: 36px; }

        /* ─── Section headings ──────────────────────────────────────── */
        .section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: #64748b;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* ─── Multi-store summary table ─────────────────────────────── */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 36px; }
        .summary-table th {
            font-size: 10px; font-weight: 600; letter-spacing: 0.06em;
            text-transform: uppercase; color: #94a3b8;
            padding: 8px 12px; text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }
        .summary-table th.center { text-align: center; }
        .summary-table td {
            padding: 10px 12px; border-bottom: 1px solid #f1f5f9;
            font-size: 12px; color: #334155;
        }
        .summary-table td.center { text-align: center; }
        .summary-table tr:last-child td { border-bottom: none; }
        .summary-table tr:hover td { background: #f8fafc; }

        /* ─── Store section header ──────────────────────────────────── */
        .store-header {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px 10px 0 0;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0;
        }
        .store-header h2 { font-size: 16px; font-weight: 700; color: #0f172a; }
        .store-header-location { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        /* ─── Overall grade hero ────────────────────────────────────── */
        .overall-grade-block {
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 12px; padding: 28px 36px;
            display: flex; align-items: center; gap: 28px;
            margin-bottom: 24px;
        }
        .grade-badge-large {
            width: 72px; height: 72px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px; font-weight: 800; flex-shrink: 0; color: #ffffff;
        }
        .overall-grade-text h2 { font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .overall-grade-text p { font-size: 12px; color: #64748b; }

        /* ─── Grade grid ────────────────────────────────────────────── */
        .grade-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px; }
        .grade-card {
            border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 18px 22px; display: flex; align-items: center; gap: 14px;
        }
        .grade-badge {
            width: 44px; height: 44px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; font-weight: 800; flex-shrink: 0; color: #ffffff;
        }
        .grade-badge-sm {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 50%;
            font-size: 12px; font-weight: 800; color: #ffffff;
        }
        .grade-card-text h3 { font-size: 13px; font-weight: 600; color: #0f172a; margin-bottom: 2px; }
        .grade-card-text span { font-size: 11px; color: #94a3b8; }

        /* ─── Metrics ───────────────────────────────────────────────── */
        .metrics-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; margin-bottom: 24px; }
        .metric-card { border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 18px 16px; }
        .metric-card-header {
            font-size: 10px; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; color: #94a3b8; margin-bottom: 12px;
        }
        .metric-primary { font-size: 24px; font-weight: 800; color: #0f172a; line-height: 1; margin-bottom: 4px; }
        .metric-label { font-size: 11px; color: #64748b; margin-bottom: 10px; }
        .metric-breakdown { font-size: 11px; color: #64748b; display: flex; flex-direction: column; gap: 4px; }
        .metric-breakdown-row { display: flex; justify-content: space-between; }
        .metric-breakdown-key { color: #94a3b8; }
        .metric-breakdown-value { font-weight: 600; color: #475569; }
        .progress-bar-track {
            height: 5px; background: #e2e8f0; border-radius: 999px;
            overflow: hidden; margin-top: 10px;
        }
        .progress-bar-fill { height: 100%; border-radius: 999px; }
        .progress-bar-fill.good { background: #10b981; }
        .progress-bar-fill.warn { background: #f59e0b; }
        .progress-bar-fill.bad  { background: #ef4444; }

        /* ─── Violation badges in table ─────────────────────────────── */
        .violation-row { display: flex; justify-content: space-between; align-items: center; padding: 5px 0; }
        .violation-row + .violation-row { border-top: 1px solid #f1f5f9; }
        .violation-label { font-size: 12px; color: #475569; }
        .violation-count {
            font-size: 12px; font-weight: 700; padding: 1px 8px;
            border-radius: 999px; background: #fee2e2; color: #dc2626;
        }
        .violation-count.zero { background: #dcfce7; color: #16a34a; }
        .violation-none { font-size: 12px; color: #94a3b8; }

        /* ─── Divider between stores ────────────────────────────────── */
        .store-divider { margin: 36px 0; border: none; border-top: 2px solid #e2e8f0; }

        /* ─── Footer ────────────────────────────────────────────────── */
        .footer {
            margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
        }
        .footer-brand { font-size: 11px; font-weight: 400; color: #94a3b8; letter-spacing: 0.04em; }
        .footer-date { font-size: 11px; color: #94a3b8; }

        /* ─── Grade colour helpers ──────────────────────────────────── */
        .grade-a { background: #10b981; }
        .grade-b { background: #3b82f6; }
        .grade-c { background: #f59e0b; }
        .grade-d { background: #f97316; }
        .grade-f { background: #ef4444; }
        .grade-na { background: #94a3b8; }
    </style>
</head>
<body>
@php
    $gradeClass = fn (string $g): string => match (strtoupper($g)) {
        'A'     => 'grade-a',
        'B'     => 'grade-b',
        'C'     => 'grade-c',
        'D'     => 'grade-d',
        'F'     => 'grade-f',
        default => 'grade-na',
    };

    $gradeDesc = fn (string $g): string => match (strtoupper($g)) {
        'A'     => 'Excellent Standing',
        'B'     => 'Good Standing',
        'C'     => 'Needs Attention',
        'D'     => 'At Risk',
        'F'     => 'Immediate Action Required',
        default => 'No data available',
    };

    $progressClass = fn (int $p): string => $p >= 80 ? 'good' : ($p >= 50 ? 'warn' : 'bad');
@endphp

{{-- ── Cover ──────────────────────────────────────────────────────── --}}
<div class="cover no-break" style="display: flex; justify-content: space-between; align-items: stretch;">
    <div>
        <div class="cover-logo"><x-application-logo /></div>
        <div class="cover-title">Compliance Summary Report</div>
        <div class="cover-subtitle">{{ $isSingleStore ? $storesData[0]['store']->name : $tenantName }}</div>
        <div class="cover-meta">
            @if(! $isSingleStore)
                <div class="cover-meta-item">
                    <span class="cover-meta-label">Locations</span>
                    <span class="cover-meta-value">{{ count($storesData) }}</span>
                </div>
            @endif
            <div class="cover-meta-item">
                <span class="cover-meta-label">Generated</span>
                <span class="cover-meta-value">{{ $generatedAt->format('M j, Y') }}</span>
            </div>
        </div>
    </div>
    @if($overallGroupGrade !== 'N/A')
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding-left: 40px; border-left: 1px solid rgba(255,255,255,0.12); margin-left: 40px;">
        <div style="font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #64a9f7; margin-bottom: 12px; white-space: nowrap;">Overall Grade</div>
        <div class="grade-badge-large {{ $gradeClass($overallGroupGrade) }}" style="width: 80px; height: 80px; font-size: 36px;">
            {{ $overallGroupGrade }}
        </div>
        <div style="font-size: 11px; color: #93c5fd; margin-top: 10px; white-space: nowrap;">{{ $gradeDesc($overallGroupGrade) }}</div>
    </div>
    @endif
</div>

<div class="body">

    {{-- ── Multi-store: summary table ─────────────────────────────── --}}
    @if(! $isSingleStore)
        <div class="section-label">All Locations — At a Glance</div>
        <table class="summary-table no-break">
            <thead>
                <tr>
                    <th>Location</th>
                    <th class="center">Overall</th>
                    <th class="center">OSHA</th>
                    <th class="center">Body Shop</th>
                    <th class="center">GLBA</th>
                    <th class="center">Deal Jacket</th>
                    <th class="center">Service Providers</th>
                    <th class="center">Unremediated</th>
                </tr>
            </thead>
            <tbody>
                @foreach($storesData as $sd)
                    <tr>
                        <td>{{ $sd['store']->name }}</td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['overallGrade']) }}">
                                {{ $sd['overallGrade'] }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['grades']['osha']) }}">
                                {{ $sd['grades']['osha'] }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['grades']['body_shop']) }}">
                                {{ $sd['grades']['body_shop'] }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['grades']['glba']) }}">
                                {{ $sd['grades']['glba'] }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['grades']['deal_jacket']) }}">
                                {{ $sd['grades']['deal_jacket'] }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="grade-badge-sm {{ $gradeClass($sd['vendorStats']['grade']) }}">
                                {{ $sd['vendorStats']['grade'] }}
                            </span>
                        </td>
                        <td class="center" style="font-weight:600; color: {{ $sd['totalOpenViolations'] === null ? '#94a3b8' : ($sd['totalOpenViolations'] > 0 ? '#dc2626' : '#16a34a') }}">
                            {{ $sd['totalOpenViolations'] ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="break-before"></div>
    @endif

    {{-- ── Per-store detail sections ───────────────────────────────── --}}
    @foreach($storesData as $index => $sd)

        @if($index > 0)
            <div class="break-before"></div>
        @endif

        {{-- Store heading (multi-store only) --}}
        @if(! $isSingleStore)
            <div class="section-label" style="margin-top: 8px;">
                {{ $sd['store']->name }}
                @if($sd['store']->city && $sd['store']->state)
                    &mdash; {{ $sd['store']->city }}, {{ $sd['store']->state }}
                @endif
            </div>
        @endif

        {{-- Audit grades --}}
        @if($isSingleStore)
            <div class="section-label">Compliance Area Grades</div>
        @endif
        <div class="grade-grid no-break">
            <div class="grade-card">
                <div class="grade-badge {{ $gradeClass($sd['grades']['osha']) }}">{{ $sd['grades']['osha'] }}</div>
                <div class="grade-card-text">
                    <h3>OSHA Safety</h3>
                    <span>Occupational safety compliance</span>
                </div>
            </div>
            <div class="grade-card">
                <div class="grade-badge {{ $gradeClass($sd['grades']['body_shop']) }}">{{ $sd['grades']['body_shop'] }}</div>
                <div class="grade-card-text">
                    <h3>Body Shop Safety</h3>
                    <span>Body shop-specific safety standards</span>
                </div>
            </div>
            <div class="grade-card">
                <div class="grade-badge {{ $gradeClass($sd['grades']['glba']) }}">{{ $sd['grades']['glba'] }}</div>
                <div class="grade-card-text">
                    <h3>GLBA</h3>
                    <span>Gramm-Leach-Bliley Act compliance</span>
                </div>
            </div>
            <div class="grade-card">
                <div class="grade-badge {{ $gradeClass($sd['grades']['deal_jacket']) }}">{{ $sd['grades']['deal_jacket'] }}</div>
                <div class="grade-card-text">
                    <h3>Deal Jacket</h3>
                    <span>Deal jacket audit pass rate</span>
                </div>
            </div>
        </div>

        {{-- Key metrics --}}
        @if($isSingleStore)
            <div class="section-label">Key Metrics</div>
        @endif
        <div class="metrics-grid no-break">

            <div class="metric-card">
                <div class="metric-card-header">Unremediated Violations</div>
                <div class="metric-primary">{{ $sd['totalOpenViolations'] ?? '-' }}</div>
                <div class="metric-label">violations awaiting remediation across all areas</div>
                <div class="metric-breakdown">
                    @foreach(['osha' => 'OSHA', 'body_shop' => 'Body Shop', 'glba' => 'GLBA'] as $key => $label)
                        @php($count = $sd['openViolations'][$key])
                        <div class="violation-row">
                            <span class="violation-label">{{ $label }}</span>
                            @if($count === null)
                                <span class="violation-none">-</span>
                            @else
                                <span class="violation-count {{ $count === 0 ? 'zero' : '' }}">{{ $count }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-card-header">Training Completion</div>
                <div class="metric-primary">{{ $sd['trainingStats']['percentage'] }}%</div>
                <div class="metric-label">of employees with completed training</div>
                <div class="metric-breakdown">
                    <div class="metric-breakdown-row">
                        <span class="metric-breakdown-key">Completed</span>
                        <span class="metric-breakdown-value">{{ $sd['trainingStats']['completed'] }}</span>
                    </div>
                    <div class="metric-breakdown-row">
                        <span class="metric-breakdown-key">Total Employees</span>
                        <span class="metric-breakdown-value">{{ $sd['trainingStats']['total'] }}</span>
                    </div>
                </div>
                <div class="progress-bar-track">
                    <div class="progress-bar-fill {{ $progressClass($sd['trainingStats']['percentage']) }}"
                         style="width: {{ $sd['trainingStats']['percentage'] }}%"></div>
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-card-header">Service Providers</div>
                <div class="metric-primary">{{ $sd['vendorStats']['percentage'] }}%</div>
                <div class="metric-label">of vendors with completed forms</div>
                <div class="metric-breakdown">
                    <div class="metric-breakdown-row">
                        <span class="metric-breakdown-key">Forms Received</span>
                        <span class="metric-breakdown-value">{{ $sd['vendorStats']['completed'] }}</span>
                    </div>
                    <div class="metric-breakdown-row">
                        <span class="metric-breakdown-key">Total Vendors</span>
                        <span class="metric-breakdown-value">{{ $sd['vendorStats']['total'] }}</span>
                    </div>
                </div>
                <div class="progress-bar-track">
                    <div class="progress-bar-fill {{ $progressClass($sd['vendorStats']['percentage']) }}"
                         style="width: {{ $sd['vendorStats']['percentage'] }}%"></div>
                </div>
            </div>

        </div>

    @endforeach

    {{-- ── Footer ──────────────────────────────────────────────────── --}}
    <div class="footer no-break">
        <span class="footer-brand">Automotive Risk Management Partners</span>
        <span class="footer-date">Generated {{ $generatedAt->format('F j, Y') }}</span>
    </div>

</div>
</body>
</html>
