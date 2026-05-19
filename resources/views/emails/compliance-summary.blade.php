<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compliance Summary</title>
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; background: #f8fafc; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background: #0f2744; padding: 32px 40px; }
        .header h1 { color: #ffffff; font-size: 20px; font-weight: 700; margin: 0 0 4px; }
        .header p { color: #93c5fd; font-size: 13px; margin: 0; }
        .body { padding: 32px 40px; }
        .body p { color: #334155; font-size: 14px; line-height: 1.6; margin: 0 0 16px; }
        .body p:last-child { margin-bottom: 0; }
        .highlight { font-weight: 600; color: #0f2744; }
        .footer { padding: 20px 40px; border-top: 1px solid #e2e8f0; background: #f8fafc; }
        .footer p { color: #94a3b8; font-size: 11px; margin: 0; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Compliance Summary Report</h1>
            <p>{{ $storeName }} &mdash; {{ $reportPeriod }}</p>
        </div>
        <div class="body">
            <p>
                Please find attached the <span class="highlight">{{ $reportPeriod }} Compliance Summary</span>
                for <span class="highlight">{{ $storeName }}</span>.
            </p>
            <p>
                This report includes your compliance grades across all active audit areas, outstanding violations,
                employee training completion, and vendor form status for the period.
            </p>
            <p>
                Review the attached PDF for the full breakdown. If you have questions or need to discuss any findings,
                please contact your ARMP compliance consultant.
            </p>
        </div>
        <div class="footer">
            <p>This is an automated message from Automotive Risk Management Partners. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
