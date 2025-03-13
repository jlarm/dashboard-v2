<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Red Sentry Report Generation Errors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #d32f2f;
        }
        .error-list {
            background-color: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ffcdd2;
        }
        .error-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .timestamp {
            color: #757575;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<h1>Red Sentry Report Generation Errors</h1>

<p>The following errors occurred during the Red Sentry report generation process:</p>

<div class="error-list">
    @foreach($errors as $index => $error)
        <div class="error-item">
            <strong>Error {{ $index + 1 }}:</strong> {{ $error }}
        </div>
    @endforeach
</div>

<p>Please investigate these issues to ensure proper report generation.</p>

<div class="timestamp">
    Generated at: {{ now()->format('Y-m-d H:i:s') }}
</div>
</body>
</html>
