@php
    $classes = [
        'expired' => 'bg-yellow-50 text-orange-700 ring-orange-600/10',
        'passed' => 'bg-green-50 text-green-700 ring-green-600/20',
        'failed' => 'bg-red-50 text-red-700 ring-red-600/10',
    ];
@endphp

<span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $classes[$type] }}">
    {{ $text }}
</span>
