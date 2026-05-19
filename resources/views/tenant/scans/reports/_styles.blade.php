<style>
    @page :first { margin: 0; }

    * { box-sizing: border-box; font-family: 'Inter', Arial, sans-serif; }
    body {
        color: #111827;
        font-size: 11px;
        margin: 0;
        padding: 0;
        line-height: 1.55;
        -webkit-font-smoothing: antialiased;
    }
    .page-break { page-break-after: always; }

    /* ---------- Cover ---------- */
    .cover {
        height: 100vh;
        padding: 64px 64px 56px;
        position: relative;
        page-break-after: always;
    }
    .cover-accent {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 8px;
        background: #006c98;
    }
    .cover-rule {
        height: 1px;
        background: #e5e7eb;
        margin: 24px 0;
    }
    .cover-eyebrow {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #6b7280;
    }
    .cover-title {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        line-height: 1.15;
        margin-top: 8px;
    }
    .cover-subject-label {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .cover-subject {
        font-size: 22px;
        font-weight: 600;
        color: #111827;
    }
    .cover-meta {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }
    .cover-meta td {
        padding: 10px 0;
        border-top: 1px solid #e5e7eb;
        font-size: 11px;
        vertical-align: top;
    }
    .cover-meta tr:first-child td {
        border-top: none;
    }
    .cover-meta .label {
        width: 180px;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-size: 9.5px;
    }
    .cover-meta .value { color: #111827; font-weight: 500; }
    .cover-footer {
        position: absolute;
        bottom: 56px;
        left: 64px;
        right: 64px;
        font-size: 9px;
        color: #9ca3af;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-top: 1px solid #e5e7eb;
        padding-top: 16px;
    }

    /* ---------- Section scaffolding ---------- */
    .section { margin-bottom: 28px; }
    .section-head {
        margin-bottom: 12px;
        page-break-after: avoid;
    }
    .section-eyebrow {
        font-size: 9.5px;
        font-weight: 700;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #006c98;
        margin-bottom: 4px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
    }
    .section-sub {
        font-size: 10.5px;
        color: #6b7280;
        margin-top: 2px;
    }
    .section-rule {
        height: 2px;
        background: #111827;
        margin-bottom: 14px;
    }

    /* ---------- Cards / panels ---------- */
    .panel {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        margin-bottom: 12px;
    }
    .data-table thead { display: table-header-group; }
    .data-table tr { page-break-inside: avoid; }
    .panel-body { padding: 16px 18px; }
    .panel-strip-head {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
    }

    /* ---------- Definition (label/value) tables ---------- */
    .kv-table { width: 100%; border-collapse: collapse; }
    .kv-table td {
        padding: 10px 14px;
        border-bottom: 1px solid #f1f3f5;
        font-size: 11px;
        vertical-align: top;
    }
    .kv-table tr:last-child td { border-bottom: none; }
    .kv-table .label {
        width: 180px;
        color: #4b5563;
        font-weight: 600;
        background: #fafbfc;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .kv-table .value { color: #111827; }

    /* ---------- Data tables ---------- */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        padding: 8px 12px;
        text-align: left;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #4b5563;
        background: #f3f4f6;
        border-bottom: 1px solid #d1d5db;
    }
    .data-table td {
        padding: 9px 12px;
        border-bottom: 1px solid #f1f3f5;
        color: #1f2937;
        font-size: 11px;
        vertical-align: top;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tbody tr:nth-child(even) td { background: #fafbfc; }

    .mono { font-family: ui-monospace, 'SFMono-Regular', Menlo, Consolas, monospace; }

    /* ---------- Metric cards ---------- */
    .metrics { width: 100%; border-collapse: separate; border-spacing: 6px 0; }
    .metric-cell {
        border: 1px solid #e5e7eb;
        padding: 12px 14px;
        vertical-align: top;
    }
    .metric-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .metric-value {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
    }
    .metric-foot {
        font-size: 9.5px;
        color: #9ca3af;
        margin-top: 3px;
    }

    /* ---------- Badges ---------- */
    .badge-table { border-collapse: collapse; }
    .badge {
        display: inline-block;
        font-size: 8.5px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 2px 7px;
        border: 1px solid transparent;
        border-radius: 2px;
        line-height: 1.3;
    }
    .badge-critical { color: #7f1d1d; background: #fef2f2; border-color: #fecaca; }
    .badge-high     { color: #9a3412; background: #fff7ed; border-color: #fed7aa; }
    .badge-medium   { color: #854d0e; background: #fefce8; border-color: #fde68a; }
    .badge-low      { color: #166534; background: #f0fdf4; border-color: #bbf7d0; }
    .badge-clean    { color: #166534; background: #f0fdf4; border-color: #bbf7d0; }
    .badge-unknown  { color: #374151; background: #f3f4f6; border-color: #d1d5db; }

    /* ---------- Severity number colors (for metric cards) ---------- */
    .sev-critical { color: #b91c1c; }
    .sev-high     { color: #c2410c; }
    .sev-medium   { color: #b45309; }
    .sev-low      { color: #15803d; }

    /* ---------- Asset / finding cards ---------- */
    .asset-card {
        border: 1px solid #e5e7eb;
        background: #ffffff;
        margin-bottom: 16px;
        page-break-inside: auto;
    }
    .asset-head {
        padding: 12px 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        page-break-after: avoid;
    }
    .asset-title {
        font-size: 12px;
        font-weight: 700;
        color: #111827;
    }
    .asset-meta {
        font-size: 10px;
        color: #6b7280;
        margin-top: 2px;
    }
    .asset-body { padding: 14px 16px; }

    .finding-card {
        border: 1px solid #e5e7eb;
        margin-bottom: 10px;
        page-break-inside: auto;
    }
    .finding-card-head {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
        page-break-after: avoid;
    }
    .finding-title {
        font-size: 12px;
        font-weight: 700;
        color: #111827;
    }
    .finding-meta {
        font-size: 10px;
        color: #6b7280;
        margin-top: 2px;
    }
    .finding-body {
        padding: 12px 14px;
    }
    .finding-block { margin-bottom: 12px; }
    .finding-block:last-child { margin-bottom: 0; }
    .finding-block-label {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .finding-block-value {
        font-size: 10.5px;
        color: #1f2937;
        line-height: 1.55;
        white-space: pre-line;
    }
    .reference-item {
        font-size: 10px;
        color: #1f2937;
        margin-bottom: 2px;
        word-break: break-word;
    }

    /* ---------- Evidence samples ---------- */
    .evidence-sample {
        border: 1px solid #e5e7eb;
        margin-top: 8px;
        page-break-inside: avoid;
    }
    .evidence-sample:first-child { margin-top: 0; }
    .evidence-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .evidence-table td {
        padding: 8px 12px;
        border-bottom: 1px solid #f1f3f5;
        vertical-align: top;
        font-size: 10px;
    }
    .evidence-table tr:last-child td { border-bottom: none; }
    .evidence-table .label {
        width: 110px;
        color: #4b5563;
        font-weight: 700;
        background: #fafbfc;
        text-transform: uppercase;
        font-size: 9px;
        letter-spacing: 0.06em;
    }
    .evidence-table .value {
        color: #1f2937;
        word-break: break-word;
        white-space: pre-line;
    }
</style>
