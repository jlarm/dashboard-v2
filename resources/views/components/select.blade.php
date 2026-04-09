@props([
     'label' => null,
     'placeholder' => null,
     'error' => null,
     'hint' => null,
     'disabled' => false,
     'required' => false,
     'multiple' => false,
     'size' => 'base',
 ])

@php
    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-2.5 py-1.5 text-sm',
        'base' => 'px-3 py-2 text-sm',
    ];

    $hasError = $error || ($attributes->has('wire:model') && $errors->has($attributes->get('wire:model')));

    $selectClasses = implode(' ', [
        'block w-full rounded-md shadow-sm border',
        'bg-white',
        'focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50',
        'transition ease-in-out duration-150',
        $hasError
            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
            : 'border-gray-300 focus:border-arm-blue-500 focus:ring-arm-blue-500',
        $sizeClasses[$size],
    ]);

    $selectId = $attributes->get('id') ?? 'select-' . Str::random(8);
@endphp

<div>
    @if ($label)
        <label for="{{ $selectId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select
        id="{{ $selectId }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        {{ $attributes->merge(['class' => $selectClasses]) }}
    >
        @if ($placeholder && !$multiple)
            <option value="" selected hidden>{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($hint && !$hasError)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="mt-1 text-sm text-red-600">
            {{ $error ?? $errors->first($attributes->get('wire:model')) }}
        </p>
    @endif
</div>
