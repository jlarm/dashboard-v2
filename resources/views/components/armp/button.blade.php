@props([
    'variant' => 'outline',
    'size' => 'base',
    'square' => false,
    'align' => 'center',
    'as' => null,
    'href' => null,
    'type' => 'button',
    'loading' => false,
    'tooltip' => null,
    'tooltipPosition' => 'top',
])

@php
    $tag = $as ?? ($href ? 'a' : 'button');

    $baseClasses = 'inline-flex items-center gap-2 rounded-lg font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = match($variant) {
        'outline' => 'border border-gray-300 bg-white text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-950 dark:text-white dark:hover:bg-gray-900',
        'primary' => 'bg-arm-blue-600 text-white hover:bg-arm-blue-700 dark:bg-arm-blue-500 dark:hover:bg-arm-blue-600',
        'filled' => 'bg-gray-100 text-gray-900 hover:bg-gray-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600',
        'ghost' => 'text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-900',
        'subtle' => 'text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-900',
        default => 'border border-gray-300 bg-white text-gray-900 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-950 dark:text-white dark:hover:bg-gray-900',
    };

    $sizeClasses = match($size) {
        'base' => 'px-4 py-2 text-sm',
        'sm' => 'h-8 px-3 text-xs',
        'xs' => 'px-2 py-1 text-xs',
        default => 'px-4 py-2 text-sm',
    };

    $alignClasses = match($align) {
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
        default => 'justify-center',
    };

    $squareClasses = $square ? 'aspect-square !p-2' : '';

    $classes = implode(' ', array_filter([$baseClasses, $variantClasses, $sizeClasses, $alignClasses, $squareClasses]));
@endphp

@if($tooltip)
<div class="relative inline-flex group">
@endif

<{{ $tag }}
    @if($tag === 'a' && $href) href="{{ $href }}" @endif
    @if($tag === 'button') type="{{ $type }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    @if(isset($icon))
        <span class="flex-shrink-0">{{ $icon }}</span>
    @endif

    @if($slot->isNotEmpty())
        <span @if($loading) wire:loading.remove wire:target="{{ $attributes->wire('click')->value() }}" @endif>
            {{ $slot }}
        </span>
    @endif

    @if(isset($iconTrailing))
        <span class="flex-shrink-0">{{ $iconTrailing }}</span>
    @endif

    @if($loading)
        <x-loading-icon
            class="size-4"
            wire:loading
            wire:target="{{ $attributes->wire('click')->value() }}"
        />
    @endif
</{{ $tag }}>

@if($tooltip)
    <div @class([
        'absolute z-50 px-3 py-2 text-xs font-medium text-white bg-zinc-800 rounded-md shadow-lg',
        'opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200',
        'max-w-sm whitespace-nowrap pointer-events-none',
        'bottom-full left-1/2 -translate-x-1/2 mb-2' => $tooltipPosition === 'top',
        'top-full left-1/2 -translate-x-1/2 mt-2' => $tooltipPosition === 'bottom',
        'right-full top-1/2 -translate-y-1/2 mr-2' => $tooltipPosition === 'left',
        'left-full top-1/2 -translate-y-1/2 ml-2' => $tooltipPosition === 'right',
    ])>
        {{ $tooltip }}
    </div>
</div>
@endif
