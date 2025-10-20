@props([
    'href' => '#',
    'icon' => null,
])

<a
    href="{{ $href }}"
    {{ $attributes->merge(['class' => 'w-full flex items-center gap-x-3 py-1.5 px-2 rounded-lg text-[13px] text-gray-800 hover:bg-gray-100 disabled:opacity-50 focus:outline-hidden focus:bg-gray-100 disabled:pointer-events-none']) }}
>
    {{ $slot }}
</a>
