@props([
    'grade'
])
<span
    @class([
        'inline-flex h-6 w-6 items-center justify-center rounded-full',
        'bg-green-100 text-green-700' => $grade == 'A',
        'bg-blue-100 text-blue-700' => $grade == 'B',
        'bg-orange-100 text-orange-700' => $grade == 'C',
        'bg-rose-100 text-rose-700' => $grade == 'D',
        'bg-red-100 text-red-700' => $grade == 'F',
    ])
    >
    {{ $slot }}
</span>
