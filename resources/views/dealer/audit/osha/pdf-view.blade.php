@php
    use Carbon\Carbon;

    $isRemediation = isset($remediation) && $remediation;
    $totalViolations = $audit->violations->count();
    $remediated = $audit->violations->filter(fn ($v) => $v->remediation?->completed)->count();
    $highRiskCount = $audit->violations->where('risk', true)->count();
    $reportTitle = $isRemediation ? 'Remediation Report' : 'OSHA Audit Report';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $fileName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #155e8a;
            --brand-dark: #0d3f5e;
            --accent: #d97706;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --bg-soft: #f8fafc;
            --danger-bg: #fef2f2;
            --danger: #b91c1c;
            --danger-line: #fecaca;
            --success-bg: #ecfdf5;
            --success: #047857;
            --success-line: #a7f3d0;
        }

        * { box-sizing: border-box; }
        html { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            color: var(--ink);
            margin: 0;
            font-size: 11pt;
            line-height: 1.55;
            background: #fff;
        }

        /* ---- Cover ---- */
        .cover {
            page-break-after: always;
            padding: 56pt 48pt;
            position: relative;
        }
        .cover__brandbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 4pt solid var(--brand);
            padding-bottom: 14pt;
            margin-bottom: 36pt;
        }
        .cover__brandbar img {
            height: 42pt;
            width: auto;
        }
        .cover__brandbar .meta {
            text-align: right;
            font-size: 9pt;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }
        .cover__eyebrow {
            color: var(--brand);
            font-size: 10pt;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 12pt;
        }
        .cover__title {
            font-size: 38pt;
            font-weight: 800;
            line-height: 1.1;
            color: var(--ink);
            margin: 0 0 8pt;
        }
        .cover__subtitle {
            font-size: 16pt;
            font-weight: 500;
            color: var(--muted);
            margin: 0 0 36pt;
        }
        .cover__stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14pt;
            margin-bottom: 36pt;
        }
        .stat {
            border: 1pt solid var(--line);
            border-radius: 8pt;
            padding: 14pt 16pt;
            background: var(--bg-soft);
        }
        .stat__label {
            font-size: 8pt;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 6pt;
            font-weight: 600;
        }
        .stat__value {
            font-size: 22pt;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }
        .stat__sub {
            font-size: 9pt;
            color: var(--muted);
            margin-top: 4pt;
        }
        .stat--grade .stat__value { color: var(--brand); }
        .stat--risk .stat__value { color: var(--danger); }

        .cover__creator {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24pt;
            border-top: 1pt solid var(--line);
            padding-top: 24pt;
        }
        .creator__label {
            font-size: 9pt;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-weight: 600;
            margin-bottom: 6pt;
        }
        .creator__name {
            font-size: 13pt;
            font-weight: 600;
            margin-bottom: 2pt;
        }
        .creator__line {
            font-size: 10pt;
            color: var(--muted);
            margin: 0;
        }

        /* ---- Body ---- */
        .body {
            padding: 36pt 48pt 48pt;
        }
        .section-heading {
            font-size: 18pt;
            font-weight: 700;
            color: var(--ink);
            margin: 0 0 18pt;
            padding-bottom: 8pt;
            border-bottom: 2pt solid var(--brand);
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .section-heading__count {
            font-size: 11pt;
            font-weight: 500;
            color: var(--muted);
        }

        /* ---- Violation card ---- */
        .violation {
            border: 1pt solid var(--line);
            border-radius: 10pt;
            padding: 18pt 20pt;
            margin-bottom: 14pt;
            page-break-inside: avoid;
            background: #fff;
        }
        .violation--risk {
            border-color: var(--danger-line);
            border-left: 4pt solid var(--danger);
        }
        .violation__header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12pt;
            margin-bottom: 10pt;
        }
        .violation__index {
            display: inline-block;
            background: var(--brand);
            color: #fff;
            font-size: 9pt;
            font-weight: 700;
            padding: 3pt 8pt;
            border-radius: 4pt;
            margin-right: 8pt;
            vertical-align: middle;
        }
        .violation__title {
            font-size: 13pt;
            font-weight: 600;
            color: var(--ink);
            margin: 0;
            flex: 1;
        }
        .violation__badges {
            display: flex;
            gap: 6pt;
            flex-shrink: 0;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .badge {
            display: inline-block;
            padding: 3pt 8pt;
            border-radius: 999pt;
            font-size: 8pt;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border: 1pt solid transparent;
        }
        .badge--risk {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: var(--danger-line);
        }
        .badge--severity {
            background: #fff7ed;
            color: #9a3412;
            border-color: #fed7aa;
        }
        .badge--remediated {
            background: var(--success-bg);
            color: var(--success);
            border-color: var(--success-line);
        }
        .violation__meta {
            font-size: 9pt;
            color: var(--muted);
            margin: 0 0 10pt;
        }
        .violation__comment {
            background: var(--bg-soft);
            border-left: 3pt solid var(--line);
            padding: 10pt 14pt;
            border-radius: 0 6pt 6pt 0;
            font-size: 10.5pt;
            color: #1e293b;
            margin: 0 0 14pt;
        }
        .violation__photos {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8pt;
            margin-bottom: 12pt;
        }
        .violation__photos img {
            width: 100%;
            height: 130pt;
            object-fit: cover;
            border-radius: 6pt;
            border: 1pt solid var(--line);
        }
        .reference {
            margin-top: 12pt;
            padding-top: 12pt;
            border-top: 1pt dashed var(--line);
        }
        .reference__label {
            font-size: 8pt;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0 0 6pt;
        }
        .reference img {
            max-height: 130pt;
            max-width: 50%;
            border-radius: 6pt;
            border: 1pt solid var(--line);
            object-fit: contain;
        }

        /* ---- Remediation panel ---- */
        .remediation {
            margin-top: 14pt;
            padding: 14pt 16pt;
            border-radius: 8pt;
            background: var(--success-bg);
            border: 1pt solid var(--success-line);
        }
        .remediation__label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 9pt;
            font-weight: 700;
            color: var(--success);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0 0 8pt;
        }
        .remediation__author {
            font-size: 9pt;
            color: var(--muted);
            font-weight: 500;
            text-transform: none;
            letter-spacing: 0;
        }
        .remediation__comment {
            font-size: 10.5pt;
            color: var(--ink);
            margin: 0 0 10pt;
        }
        .remediation__photo img {
            max-height: 160pt;
            max-width: 60%;
            border-radius: 6pt;
            border: 1pt solid var(--success-line);
            object-fit: cover;
        }

        /* ---- Comments ---- */
        .comments {
            margin-top: 28pt;
        }
        .comment {
            display: flex;
            gap: 12pt;
            padding: 12pt 14pt;
            border: 1pt solid var(--line);
            border-radius: 8pt;
            margin-bottom: 8pt;
            page-break-inside: avoid;
        }
        .avatar {
            flex-shrink: 0;
            width: 28pt;
            height: 28pt;
            border-radius: 999pt;
            background: var(--brand);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 10pt;
        }
        .comment__body { flex: 1; }
        .comment__head {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 4pt;
        }
        .comment__author {
            font-weight: 600;
            font-size: 10pt;
        }
        .comment__time {
            font-size: 9pt;
            color: var(--muted);
        }
        .comment__text {
            margin: 0 0 8pt;
            font-size: 10pt;
            color: #1e293b;
        }
        .comment__photo img {
            max-height: 120pt;
            max-width: 50%;
            border-radius: 6pt;
            border: 1pt solid var(--line);
        }

        .empty {
            border: 1pt dashed var(--line);
            border-radius: 8pt;
            padding: 24pt;
            text-align: center;
            color: var(--muted);
            font-size: 10pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Cover -->
    <section class="cover">
        <header class="cover__brandbar">
            <img src="{{ asset('armp-rb-logo.png') }}" alt="Automotive Risk Management Partners">
            <div class="meta">
                <div>{{ now()->format('F j, Y') }}</div>
                <div>Confidential</div>
            </div>
        </header>

        <p class="cover__eyebrow">{{ $isRemediation ? 'OSHA Remediation' : 'OSHA Compliance Audit' }}</p>
        <h1 class="cover__title">{{ $reportTitle }}</h1>
        <p class="cover__subtitle">{{ $audit->store->name }}</p>

        <div class="cover__stats">
            <div class="stat stat--grade">
                <div class="stat__label">Grade</div>
                <div class="stat__value">{{ $audit->grade ?? '—' }}</div>
                <div class="stat__sub">Audit grade</div>
            </div>
            <div class="stat">
                <div class="stat__label">Audit Date</div>
                <div class="stat__value" style="font-size: 14pt;">{{ $audit->date?->format('M j, Y') }}</div>
                <div class="stat__sub">{{ $audit->completed_date ? 'Completed '.$audit->completed_date->format('M j, Y') : 'In progress' }}</div>
            </div>
            <div class="stat">
                <div class="stat__label">Violations</div>
                <div class="stat__value">{{ $totalViolations }}</div>
                <div class="stat__sub">{{ $remediated }} remediated</div>
            </div>
            <div class="stat stat--risk">
                <div class="stat__label">High Risk</div>
                <div class="stat__value">{{ $highRiskCount }}</div>
                <div class="stat__sub">flagged items</div>
            </div>
        </div>

        <div class="cover__creator">
            <div>
                <div class="creator__label">Prepared by</div>
                <div class="creator__name">{{ $audit->user->name ?? 'Unknown' }}</div>
                @if($audit->user->phoneNumber ?? null)
                    <p class="creator__line">{{ $audit->user->phoneNumber }}</p>
                @endif
                @if($audit->user->email ?? null)
                    <p class="creator__line">{{ $audit->user->email }}</p>
                @endif
            </div>
            <div>
                <div class="creator__label">Location</div>
                <div class="creator__name">{{ $audit->store->name }}</div>
                @if($audit->store->address ?? null)
                    <p class="creator__line">{{ $audit->store->address }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Body -->
    <section class="body">
        <h2 class="section-heading">
            <span>Violations</span>
            <span class="section-heading__count">{{ $totalViolations }} {{ Str::plural('item', $totalViolations) }}</span>
        </h2>

        @if($totalViolations === 0)
            <div class="empty">No violations recorded for this audit.</div>
        @endif

        @foreach($audit->violations as $index => $violation)
            <article class="violation {{ $violation->risk ? 'violation--risk' : '' }}">
                <div class="violation__header">
                    <h3 class="violation__title">
                        <span class="violation__index">{{ $index + 1 }}</span>{{ $violation->statement }}
                    </h3>
                    <div class="violation__badges">
                        @if($violation->risk)
                            <span class="badge badge--risk">High Risk</span>
                        @endif
                        @if($violation->severity !== null)
                            <span class="badge badge--severity">Severity {{ $violation->severity }}</span>
                        @endif
                        @if($violation->remediation?->completed)
                            <span class="badge badge--remediated">Remediated</span>
                        @endif
                    </div>
                </div>

                @if($violation->violation_date)
                    <p class="violation__meta">Observed {{ $violation->violation_date->format('F j, Y') }}</p>
                @endif

                @if($violation->comment)
                    <p class="violation__comment">{{ $violation->comment }}</p>
                @endif

                @php
                    $photos = collect();
                    foreach ([0, 1, 2] as $position) {
                        $media = $violation->getMedia('violation_files_'.$position)->first();
                        if ($media) {
                            $photos->push($media);
                        }
                    }
                @endphp

                @if($photos->isNotEmpty())
                    <div class="violation__photos">
                        @foreach($photos as $media)
                            <img src="{{ $media->getTemporaryUrl(Carbon::now()->addHour(), 'thumb') }}" alt="Violation photo">
                        @endforeach
                    </div>
                @endif

                @if($violation->show_reference_image && ($referenceImagesByStatementId[$violation->statement_id] ?? null))
                    <div class="reference">
                        <p class="reference__label">Reference Image</p>
                        <img src="{{ $referenceImagesByStatementId[$violation->statement_id] }}" alt="Reference image">
                    </div>
                @endif

                @if($isRemediation && $violation->remediation)
                    <div class="remediation">
                        <div class="remediation__label">
                            <span>Remediation</span>
                            <span class="remediation__author">
                                {{ $violation->remediation->updated_at?->format('M j, Y') }}
                                @if($violation->remediation->user) · {{ $violation->remediation->user->name }} @endif
                            </span>
                        </div>
                        @if($violation->remediation->comment)
                            <p class="remediation__comment">{{ $violation->remediation->comment }}</p>
                        @endif
                        @if($violation->remediation->getFirstMedia('remediations'))
                            <div class="remediation__photo">
                                <img src="{{ $violation->remediation->getFirstMedia('remediations')->getTemporaryUrl(Carbon::now()->addHour(), 'thumb') }}" alt="Remediation photo">
                            </div>
                        @endif
                    </div>
                @endif
            </article>
        @endforeach

        @if($audit->auditComments->count() > 0)
            <div class="comments">
                <h2 class="section-heading">
                    <span>Comments</span>
                    <span class="section-heading__count">{{ $audit->auditComments->count() }} {{ Str::plural('note', $audit->auditComments->count()) }}</span>
                </h2>

                @foreach($audit->auditComments as $comment)
                    @php
                        $name = $comment->user?->name ?? 'Unknown';
                        $initials = collect(explode(' ', $name))->filter()->take(2)->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))->implode('');
                    @endphp
                    <div class="comment">
                        <div class="avatar">{{ $initials ?: '?' }}</div>
                        <div class="comment__body">
                            <div class="comment__head">
                                <span class="comment__author">{{ $name }}</span>
                                <span class="comment__time">{{ $comment->created_at?->format('M j, Y · g:i A') }}</span>
                            </div>
                            <p class="comment__text">{{ $comment->comment }}</p>
                            @if($comment->getFirstMedia('comment-photos') ?? $comment->getFirstMedia('comments'))
                                @php
                                    $media = $comment->getFirstMedia('comment-photos') ?? $comment->getFirstMedia('comments');
                                @endphp
                                <div class="comment__photo">
                                    <img src="{{ $media->getTemporaryUrl(Carbon::now()->addHour(), 'thumb') }}" alt="Comment attachment">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</body>
</html>
