<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $dealershipName }} — {{ $manualTitle }}</title>
    <style>
        @page {
            size: letter;
            margin: 0.85in 0.75in 0.95in;
        }

        :root {
            --armp-blue: #006c98;
            --armp-blue-light: #2f8fbb;
            --armp-green: #71984a;
            --armp-orange: #ec7700;
            --ink: #1f2937;
            --ink-soft: #4b5563;
            --ink-muted: #6b7280;
            --rule: #d1d5db;
            --rule-soft: #e5e7eb;
            --surface-soft: #f3f4f6;
        }

        html, body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Arial, sans-serif;
            font-size: 10.5pt;
            line-height: 1.5;
            color: var(--ink);
            margin: 0;
            padding: 0;
        }

        /* ----- Cover page ----- */
        .cover {
            page-break-after: always;
            text-align: center;
            padding-top: 1.25in;
        }

        .cover__logo {
            width: 2.4in;
            height: auto;
            margin: 0 auto 0.6in;
            display: block;
        }

        .cover__dealership {
            font-size: 26pt;
            font-weight: 700;
            color: var(--armp-blue);
            letter-spacing: -0.01em;
            line-height: 1.15;
            margin: 0 0 0.15in;
        }

        .cover__title {
            font-size: 18pt;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin: 0 0 0.85in;
        }

        .cover__meta {
            display: inline-block;
            text-align: left;
            font-size: 11pt;
            line-height: 1.7;
            color: var(--ink-soft);
            border-top: 2px solid var(--armp-blue);
            border-bottom: 1px solid var(--rule);
            padding: 0.2in 0.4in;
        }

        .cover__meta-date {
            color: var(--armp-blue);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 9pt;
            margin-bottom: 0.05in;
        }

        /* ----- ARMP rep signature page (its own page so it never gets clipped) ----- */
        .cover-signatures-page {
            page-break-before: always;
            page-break-after: always;
            padding-top: 1in;
        }

        .cover-signatures-page__title {
            font-size: 18pt;
            font-weight: 700;
            color: var(--armp-blue);
            margin: 0 0 0.05in;
            text-align: center;
        }

        .cover-signatures-page__subtitle {
            font-size: 10.5pt;
            color: var(--ink-muted);
            text-align: center;
            margin: 0 0 0.6in;
        }

        .cover-signatures {
            margin: 0 auto;
            width: 5.5in;
            border-collapse: collapse;
            font-size: 9pt;
        }

        .cover-signatures th {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--ink-muted);
            font-weight: 600;
            text-align: left;
            border-bottom: 1.5px solid var(--armp-blue);
            padding: 0 0.1in 0.08in;
        }

        .cover-signatures td {
            border-bottom: 1px solid var(--rule);
            height: 0.55in;
            padding: 0 0.1in;
        }

        /* ----- Table of contents ----- */
        .toc {
            page-break-after: always;
        }

        .toc__title {
            font-size: 22pt;
            font-weight: 700;
            color: var(--armp-blue);
            letter-spacing: -0.01em;
            margin: 0 0 0.05in;
        }

        .toc__rule {
            border: 0;
            border-top: 2px solid var(--armp-blue);
            margin: 0 0 0.3in;
        }

        .toc__list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .toc__entry {
            display: flex;
            align-items: flex-end;
            gap: 0.1in;
            margin-bottom: 0.12in;
            font-size: 10.5pt;
        }

        .toc__entry--nested {
            padding-left: 0.45in;
            font-size: 10pt;
            color: var(--ink-soft);
        }

        .toc__label {
            flex: 0 0 auto;
        }

        .toc__leader {
            flex: 1 1 auto;
            border-bottom: 1px dotted var(--ink-muted);
            transform: translateY(-3px);
        }

        .toc__page {
            flex: 0 0 auto;
            color: var(--ink-soft);
            font-variant-numeric: tabular-nums;
            min-width: 0.3in;
            text-align: right;
        }

        /* ----- Body content scope ----- */
        .body > section,
        .body > article {
            page-break-before: always;
        }

        .body > section:first-of-type,
        .body > article:first-of-type {
            page-break-before: auto;
        }

        .body h1 {
            font-size: 18pt;
            font-weight: 700;
            color: var(--armp-blue);
            margin: 0 0 0.05in;
            letter-spacing: -0.01em;
        }

        .body h1::after {
            content: "";
            display: block;
            width: 1.2in;
            border-bottom: 3px solid var(--armp-blue);
            margin-top: 0.08in;
            margin-bottom: 0.25in;
        }

        .body h2 {
            font-size: 13pt;
            font-weight: 600;
            color: var(--ink);
            margin: 0.3in 0 0.1in;
            page-break-after: avoid;
        }

        .body h3 {
            font-size: 11.5pt;
            font-weight: 600;
            color: var(--armp-blue-light);
            margin: 0.18in 0 0.08in;
            page-break-after: avoid;
        }

        .body h4 {
            font-size: 10.5pt;
            font-weight: 600;
            color: var(--ink);
            margin: 0.15in 0 0.06in;
            page-break-after: avoid;
        }

        /* ----- Body content ----- */
        p {
            margin: 0 0 0.12in;
        }

        ul, ol {
            margin: 0.08in 0 0.15in 0.25in;
            padding-left: 0.1in;
        }

        li {
            margin-bottom: 0.05in;
        }

        ul ul, ol ol, ul ol, ol ul {
            margin-top: 0.05in;
            margin-bottom: 0.05in;
        }

        strong {
            font-weight: 600;
        }

        /* Pull-out callout for definitions or notices */
        .callout {
            border-left: 3px solid var(--armp-blue);
            background: var(--surface-soft);
            padding: 0.15in 0.2in;
            margin: 0.15in 0;
            font-size: 10pt;
        }

        .callout__title {
            font-weight: 600;
            color: var(--armp-blue);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 9pt;
            margin: 0 0 0.05in;
        }

        /* ----- Tables ----- */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 0.15in 0 0.2in;
            font-size: 10pt;
        }

        table.data thead th {
            text-align: left;
            font-weight: 600;
            color: var(--ink);
            border-bottom: 1.5px solid var(--armp-blue);
            padding: 0.07in 0.12in;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 8.5pt;
        }

        table.data tbody td {
            border-bottom: 1px solid var(--rule-soft);
            padding: 0.07in 0.12in;
            vertical-align: top;
        }

        table.data tbody tr:nth-child(even) td {
            background: #fafafa;
        }

        table.data .name {
            font-weight: 600;
        }

        table.data .role {
            color: var(--ink-muted);
            font-size: 9pt;
            display: block;
            margin-top: 0.02in;
        }

        /* Personnel block (used on the cover/intro pages) */
        .personnel {
            margin-top: 0.4in;
        }

        .personnel__title {
            font-size: 11pt;
            font-weight: 600;
            color: var(--armp-blue);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.1in;
        }

        /* Emergency block */
        .emergency {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.12in 0.3in;
            margin-top: 0.25in;
            padding: 0.15in 0.2in;
            background: var(--surface-soft);
            border-radius: 4px;
            font-size: 9.5pt;
        }

        .emergency dt {
            color: var(--ink-muted);
            font-size: 8.5pt;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .emergency dd {
            margin: 0;
            font-weight: 600;
            color: var(--ink);
        }

        /* Signature block (final page) */
        .signature {
            page-break-before: always;
            margin-top: 0.6in;
        }

        .signature__row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.3in;
            margin-bottom: 0.6in;
        }

        .signature__field {
            border-bottom: 1px solid var(--ink);
            padding-bottom: 0.05in;
            font-size: 10pt;
            min-height: 0.5in;
            display: flex;
            align-items: flex-end;
        }

        .signature__label {
            font-size: 8.5pt;
            color: var(--ink-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 0.04in;
        }

        /* Force page breaks where the original template asked for them */
        .page-break {
            page-break-after: always;
        }

        .no-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
@yield('content')
</body>
</html>
