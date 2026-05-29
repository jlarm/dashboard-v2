<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compliance Information — {{ $store->name }}</title>
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

        .no-break { page-break-inside: avoid; break-inside: avoid; }
        .break-before { page-break-before: always; break-before: page; }

        .cover-logo { width: 180px; margin-bottom: 28px; }
        .cover-logo svg path,
        .cover-logo svg .cls-1 { fill: #ffffff !important; }

        .cover {
            background: #0f2744;
            color: #ffffff;
            padding: 48px 56px 48px;
            margin-bottom: 36px;
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

        .body { padding-top: 8px; }

        .section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: #64748b;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .section-label.spaced { margin-top: 28px; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 18px;
            margin-bottom: 8px;
        }
        .info-grid.single { grid-template-columns: 1fr; }

        .info-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            background: #ffffff;
        }
        .info-card-label {
            font-size: 10px; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; color: #94a3b8;
            margin-bottom: 6px;
        }
        .info-card-value {
            font-size: 13px; font-weight: 500; color: #0f172a;
            word-break: break-word;
        }
        .info-card-value.empty { color: #cbd5e1; font-weight: 400; font-style: italic; }

        .pill-yes, .pill-no, .pill-na {
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; padding: 3px 10px;
            border-radius: 999px; letter-spacing: 0.04em;
        }
        .pill-yes { background: #dcfce7; color: #16a34a; }
        .pill-no  { background: #fee2e2; color: #dc2626; }
        .pill-na  { background: #f1f5f9; color: #94a3b8; }

        .list-card { padding: 12px 14px; }
        .list-card .info-card-value { margin-top: 4px; }
        .list-card ul { list-style: none; margin: 0; padding: 0; }
        .list-card li {
            font-size: 12px; color: #334155;
            padding: 4px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .list-card li:last-child { border-bottom: none; }
        .list-card .empty {
            font-size: 12px; color: #cbd5e1; font-style: italic;
        }
    </style>
</head>
<body>
@php
    $blank = static fn ($value): bool => $value === null || $value === '' || $value === [];
    $textValue = static function ($value) use ($blank): array {
        return $blank($value)
            ? ['display' => '—', 'empty' => true]
            : ['display' => (string) $value, 'empty' => false];
    };
    $yesNo = static function ($value): string {
        if ($value === null || $value === '') { return 'na'; }
        return ((int) $value === 1) ? 'yes' : 'no';
    };
@endphp

<div class="cover no-break">
    <div class="cover-logo"><x-application-logo /></div>
    <div class="cover-title">Compliance Information</div>
    <div class="cover-subtitle">{{ $store->name }}</div>
    <div class="cover-meta">
        @if($store->city && $store->state)
            <div class="cover-meta-item">
                <span class="cover-meta-label">Location</span>
                <span class="cover-meta-value">{{ $store->city }}, {{ $store->state }}</span>
            </div>
        @endif
        <div class="cover-meta-item">
            <span class="cover-meta-label">Generated</span>
            <span class="cover-meta-value">{{ $generatedAt->format('M j, Y') }}</span>
        </div>
    </div>
</div>

<div class="body">

    {{-- ── Managers ────────────────────────────────────────────────── --}}
    <div class="section-label">Managers &amp; Key Personnel</div>
    @php
        $managerRows = [
            ['Qualified Individual', $managers->qualified_individual_name ?? null, $managers->qualified_individual_phone ?? null],
            ['Service Manager',      $managers->service_manager_name ?? null,      $managers->service_manager_phone ?? null],
            ['Parts Manager',        $managers->parts_manager_name ?? null,        $managers->parts_manager_phone ?? null],
            ['Body Shop Manager',    $managers->body_shop_manager_name ?? null,    $managers->body_shop_manager_phone ?? null],
            ['General Manager',      $managers->general_manager_name ?? null,      $managers->general_manager_phone ?? null],
            ['Owner',                $managers->owner_name ?? null,                $managers->owner_phone ?? null],
        ];
    @endphp
    <div class="info-grid no-break">
        @foreach($managerRows as [$role, $name, $phone])
            @php
                $n = $textValue($name);
                $p = $textValue($phone);
            @endphp
            <div class="info-card">
                <div class="info-card-label">{{ $role }}</div>
                <div class="info-card-value {{ $n['empty'] ? 'empty' : '' }}">{{ $n['display'] }}</div>
                <div class="info-card-value {{ $p['empty'] ? 'empty' : '' }}" style="font-size: 12px; color: #475569; margin-top: 2px;">{{ $p['display'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ── Emergency Contacts ─────────────────────────────────────── --}}
    <div class="section-label spaced">Emergency Contacts</div>
    @php
        $emergencyRows = [
            ['Police Emergency',      $store->police_emergency_phone],
            ['Police Non-Emergency',  $store->police_non_emergency_phone],
            ['Fire Emergency',        $store->fire_emergency_phone],
            ['Fire Non-Emergency',    $store->fire_non_emergency_phone],
            ['Fire Alarm Type',       $store->fire_alarm_type],
            ['Burglar Alarm Type',    $store->burglar_alarm_type],
        ];
    @endphp
    <div class="info-grid no-break">
        @foreach($emergencyRows as [$label, $value])
            @php
                $v = $textValue($value);
            @endphp
            <div class="info-card">
                <div class="info-card-label">{{ $label }}</div>
                <div class="info-card-value {{ $v['empty'] ? 'empty' : '' }}">{{ $v['display'] }}</div>
            </div>
        @endforeach
    </div>

    {{-- ── IT Security ─────────────────────────────────────────────── --}}
    <div class="section-label spaced">IT Security</div>
    @php
        $itRows = [
            ['Firewall Company',                                        $store->firewall_company],
            ['Antivirus Software',                                      $store->antivirus_software],
            ['Antivirus Applied On',                                    $store->antivirus_computers],
            ['Antivirus Update Frequency (min)',                        $store->antivirus_minutes],
            ['Screen Saver Activation (min)',                           $store->screensaver_minutes],
            ['Dealership Management System (DMS)',                      $store->dms_provider],
            ['Backup Storage',                                          $store->backups],
        ];
        $itToggles = [
            ['Multi-Factor Authentication',          $yesNo($store->mfa)],
            ['IT Vulnerability Scans',               $yesNo($store->vulnerability)],
            ['User Activity Monitoring &amp; Logging',   $yesNo($store->currently_monitoring ?? null)],
        ];
    @endphp
    <div class="info-grid no-break">
        @foreach($itRows as [$label, $value])
            @php
                $v = $textValue($value);
            @endphp
            <div class="info-card">
                <div class="info-card-label">{{ $label }}</div>
                <div class="info-card-value {{ $v['empty'] ? 'empty' : '' }}">{{ $v['display'] }}</div>
            </div>
        @endforeach
        @foreach($itToggles as [$label, $state])
            <div class="info-card">
                <div class="info-card-label">{!! $label !!}</div>
                <div class="info-card-value">
                    @if($state === 'yes') <span class="pill-yes">Yes</span>
                    @elseif($state === 'no') <span class="pill-no">No</span>
                    @else <span class="pill-na">N/A</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── IP Addresses + Website URLs (lists) ────────────────────── --}}
    <div class="info-grid no-break" style="margin-top: 14px;">
        <div class="info-card list-card">
            <div class="info-card-label">IP Addresses</div>
            @if($store->ip_addresses)
                <ul>
                    @foreach($store->ip_addresses as $ip)
                        <li>{{ $ip }}</li>
                    @endforeach
                </ul>
            @else
                <span class="empty">No IP addresses on file</span>
            @endif
        </div>
        <div class="info-card list-card">
            <div class="info-card-label">Website URLs</div>
            @if($store->website_urls)
                <ul>
                    @foreach($store->website_urls as $url)
                        <li>{{ $url }}</li>
                    @endforeach
                </ul>
            @else
                <span class="empty">No website URLs on file</span>
            @endif
        </div>
    </div>

    {{-- ── Policies & Compliance ──────────────────────────────────── --}}
    <div class="section-label spaced">Policies &amp; Compliance</div>
    @php
        $redFlag = $textValue($store->designated_red_flag_coordinator);
        $policyToggles = [
            ['Document Shredding Company',                $yesNo($store->document_shredding)],
            ['Service Provider Agreements On File',       $yesNo($store->service_provider_agreements)],
            ['Customer Data At Offsite Locations',        $yesNo($store->offsite_storage)],
            ['Affiliation With Other Business (&gt;25%)',     $yesNo($store->other_business)],
            ['After-Hour Vendor Access',                  $yesNo($store->vendor_access)],
            ['Customer Data On Personal Devices',         $yesNo($store->personal_devices)],
            ['Reported Compliance Issues',                $yesNo($store->compliance_issues)],
        ];
    @endphp
    <div class="info-grid no-break">
        <div class="info-card" style="grid-column: span 2;">
            <div class="info-card-label">Designated Red Flag Coordinator</div>
            <div class="info-card-value {{ $redFlag['empty'] ? 'empty' : '' }}">{{ $redFlag['display'] }}</div>
        </div>
        @foreach($policyToggles as [$label, $state])
            <div class="info-card">
                <div class="info-card-label">{!! $label !!}</div>
                <div class="info-card-value">
                    @if($state === 'yes') <span class="pill-yes">Yes</span>
                    @elseif($state === 'no') <span class="pill-no">No</span>
                    @else <span class="pill-na">N/A</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── F&I ─────────────────────────────────────────────────────── --}}
    <div class="section-label spaced">F&amp;I</div>
    @php
        $fiRows = [
            ['F&amp;I Products Sold',                        $store->fi_products_sold],
            ['F&amp;I System',                               $store->fi_system],
            ['Appearance Protection Sold Location',      $store->appearance_protection_sold],
            ['Administrator',                            $store->admin_name],
            ['F&amp;I Logs Username',                        $store->fi_username],
            ['Standard DPP Rate',                        $store->standard_dpp_rate],
        ];
    @endphp
    <div class="info-grid no-break">
        @foreach($fiRows as [$label, $value])
            @php
                $v = $textValue($value);
            @endphp
            <div class="info-card">
                <div class="info-card-label">{!! $label !!}</div>
                <div class="info-card-value {{ $v['empty'] ? 'empty' : '' }}">{{ $v['display'] }}</div>
            </div>
        @endforeach
        <div class="info-card">
            <div class="info-card-label">Reinsurance Company Formed</div>
            <div class="info-card-value">
                @if($store->reinsurance) <span class="pill-yes">Yes</span>
                @else <span class="pill-no">No</span>
                @endif
            </div>
        </div>
    </div>

    {{-- ── F&I Product Lists ──────────────────────────────────────── --}}
    <div class="info-grid no-break" style="margin-top: 14px;">
        <div class="info-card list-card">
            <div class="info-card-label">Service Contracts (New &amp; Used)</div>
            @if($store->service_contracts)
                <ul>
                    @foreach($store->service_contracts as $contract)
                        <li>{{ $contract }}</li>
                    @endforeach
                </ul>
            @else
                <span class="empty">None on file</span>
            @endif
        </div>
        <div class="info-card list-card">
            <div class="info-card-label">Combo / Tire &amp; Wheel</div>
            @if($store->tire_wheel)
                <ul>
                    @foreach($store->tire_wheel as $tire)
                        <li>{{ $tire }}</li>
                    @endforeach
                </ul>
            @else
                <span class="empty">None on file</span>
            @endif
        </div>
        <div class="info-card list-card" style="grid-column: span 2;">
            <div class="info-card-label">Other (Etch, Security Systems, GPS)</div>
            @if($store->other_fi)
                <ul>
                    @foreach($store->other_fi as $other)
                        <li>{{ $other }}</li>
                    @endforeach
                </ul>
            @else
                <span class="empty">None on file</span>
            @endif
        </div>
    </div>

</div>
</body>
</html>
