@props([
      'type' => 'text',
      'variant' => 'outline',
      'size' => 'base',
      'label' => null,
      'error' => null,
      'hint' => null,
      'icon' => null,
      'iconTrailing' => null,
      'disabled' => false,
      'readonly' => false,
      'required' => false,
  ])

@php
    $variantClasses = [
        'outline' => 'bg-white border-gray-300',
        'filled' => 'bg-gray-100 border-transparent',
    ];

    $sizeClasses = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-2.5 py-1.5 text-sm',
        'base' => 'px-3 py-2 text-sm',
    ];

    $hasError = $error || ($attributes->has('wire:model') && $errors->has($attributes->get('wire:model')));

    $isFile = $type === 'file';

    $inputClasses = implode(' ', [
        'block w-full rounded-md shadow-sm',
        'border focus:outline-none focus:ring-2 focus:ring-offset-0',
        'disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50',
        'readonly:bg-gray-50 readonly:text-gray-500',
        'transition ease-in-out duration-150',
        $hasError
            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
            : 'focus:border-arm-blue-500 focus:ring-arm-blue-500',
        $variantClasses[$variant],
        $isFile ? 'p-0 cursor-pointer text-gray-500' : $sizeClasses[$size],
        $isFile ? 'file:cursor-pointer file:border-0 file:border-r file:border-gray-200 file:mr-3 file:px-3 file:py-2 file:text-sm file:font-medium file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100' : '',
        $icon ? 'pl-10' : '',
        $iconTrailing ? 'pr-10' : '',
    ]);

    $inputId = $attributes->get('id') ?? 'input-' . Str::random(8);
@endphp

<div>
    @if ($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <span class="text-gray-400">
                      {{ $icon }}
                  </span>
            </div>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $readonly ? 'readonly' : '' }}
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => $inputClasses]) }}
        />

        @if ($iconTrailing)
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                  <span class="text-gray-400">
                      {{ $iconTrailing }}
                  </span>
            </div>
        @endif
    </div>

    @if ($hint && !$hasError)
        <p class="mt-1 text-xs text-gray-500">{{ $hint }}</p>
    @endif

    @if ($hasError)
        <p class="mt-1 text-sm text-red-600">
            {{ $error ?? $errors->first($attributes->get('wire:model')) }}
        </p>
    @endif
</div>
