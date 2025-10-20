@props([
      'variant' => 'outline',
      'size' => 'base',
      'type' => 'button',
      'href' => null,
      'icon' => null,
      'iconTrailing' => null,
  ])

@php
    $variantClasses = [
        'outline' => 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:ring-arm-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700',
        'primary' => 'bg-arm-blue-600 text-white hover:bg-arm-blue-700 focus:ring-arm-blue-500 dark:bg-arm-blue-500 dark:hover:bg-arm-blue-600',
        'filled' => 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-400 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600',
        'ghost' => 'bg-transparent border-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-400 dark:text-gray-300 dark:hover:bg-gray-800',
        'subtle' => 'bg-transparent border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:ring-gray-400 dark:text-gray-400 dark:hover:text-gray-100 dark:hover:bg-gray-800',
    ];

    $sizeClasses = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'base' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2.5 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];

    $classes = implode(' ', [
        'inline-flex items-center justify-center gap-2',
        'border rounded-md font-semibold',
        'focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-900',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        'transition ease-in-out duration-150',
        $variantClasses[$variant],
        $sizeClasses[$size],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span>{{ $icon }}</span>
        @endif

        {{ $slot }}

        @if ($iconTrailing)
            <span>{{ $iconTrailing }}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            <span>{{ $icon }}</span>
        @endif

        {{ $slot }}

        @if ($iconTrailing)
            <span>{{ $iconTrailing }}</span>
        @endif
    </button>
@endif
