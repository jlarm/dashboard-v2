@php
    /** @var string $reportType */
    /** @var string $storeName */
    /** @var array<int, array{label: string, value: string|null}> $metaRows */
@endphp
<div class="cover">
    <div class="cover-accent"></div>

    <img src="{{ public_path('armp-rb-logo.png') }}" style="width: 200px; height: auto; margin-top: 16px;" />

    <div class="cover-rule"></div>

    <div class="cover-eyebrow">{{ strtoupper($reportType) }} REPORT</div>
    <div class="cover-title">Cybersecurity Risk Assessment</div>

    <div style="margin-top: 64px;">
        <div class="cover-subject-label">Prepared for</div>
        <div class="cover-subject">{{ $storeName }}</div>
    </div>

    <table class="cover-meta">
        @foreach ($metaRows as $row)
            @if (!empty($row['value']))
                <tr>
                    <td class="label">{{ $row['label'] }}</td>
                    <td class="value">{{ $row['value'] }}</td>
                </tr>
            @endif
        @endforeach
    </table>
</div>
