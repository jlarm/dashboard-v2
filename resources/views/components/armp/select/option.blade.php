@aware(['variant' => 'native', 'multiple' => false, 'size' => 'base'])

@props([
    'value' => null,
])

@php
    $optionValue = $value ?? trim(strip_tags($slot->toHtml()));
    $optionLabel = trim(strip_tags($slot->toHtml()));

    $sizes = [
        'xs'   => 'px-2 py-1 text-xs',
        'sm'   => 'px-2.5 py-1 text-sm',
        'base' => 'px-3 py-1.5 text-sm',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['base'];
@endphp

@if ($variant === 'native')
    <option value="{{ $optionValue }}" {{ $attributes }}>{{ $slot }}</option>
@else
    <div
        data-option-value="{{ $optionValue }}"
        data-option-label="{{ $optionLabel }}"
        role="option"
        aria-selected="false"
        tabindex="-1"
        {{ $attributes->merge([
            'class' => implode(' ', [
                'flex items-center justify-between gap-2 rounded-lg cursor-default select-none transition-colors duration-75',
                'text-zinc-700',
                $sizeClass,
            ]),
        ]) }}
    >
        <span class="flex items-center gap-2 truncate">
            {{ $slot }}
        </span>

        @if ($multiple)
            <span data-checkbox class="flex-shrink-0 flex items-center justify-center size-4 rounded border border-zinc-300 transition-colors">
                <svg class="size-3 text-white hidden" data-checkbox-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
            </span>
        @else
            <span data-check class="flex-shrink-0 opacity-0 transition-opacity duration-75">
                <svg class="size-4 text-zinc-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
            </span>
        @endif
    </div>
@endif
