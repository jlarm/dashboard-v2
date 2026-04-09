@props([
      'name' => $attributes->whereStartsWith('wire:model')->first(),
      'label' => null,
      'description' => null,
      'descriptionTrailing' => null,
      'resize' => 'vertical',
      'invalid' => null,
      'rows' => 4,
  ])

@php
    $invalid ??= ($name && $errors->has($name));

    $classes = collect([
        'block p-3 w-full',
        'shadow-xs disabled:shadow-none border rounded-lg',
        'bg-white',
        $resize !== 'none' ? "resize-{$resize}" : 'resize-none',
        'text-base sm:text-sm text-zinc-700 disabled:text-zinc-500 placeholder-zinc-400 disabled:placeholder-zinc-400/70',
        'outline-none transition-colors',
        $invalid
            ? 'border-red-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/20'
            : 'border-zinc-200 border-b-zinc-300/80 focus:border-arm-blue focus:ring-2 focus:ring-arm-blue/20',
    ])->filter()->implode(' ');

    $resizeStyle = match ($resize) {
        'none' => 'resize: none',
        'both' => 'resize: both',
        'horizontal' => 'resize: horizontal',
        'vertical' => 'resize: vertical',
        default => 'resize: vertical',
    };

    $autoSizing = $rows === 'auto' ? 'field-sizing: content' : '';
@endphp

<div>
    @if ($label)
        <label
            @if ($name) for="{{ $name }}" @endif
        class="block text-sm font-medium text-zinc-700 mb-1"
        >
            {{ $label }}
        </label>
    @endif

    @if ($description)
        <div class="text-sm text-zinc-500 mb-2">
            {{ $description }}
        </div>
    @endif

    <textarea
        {{ $attributes->class($classes) }}
        rows="{{ $rows }}"
        style="{{ $resizeStyle }}; {{ $autoSizing }}"
        @if ($name)
            name="{{ $name }}"
        id="{{ $name }}"
        @endif
        @if ($invalid)
            aria-invalid="true"
        aria-describedby="{{ $name }}-error"
          @endif
      >{{ $slot }}</textarea>

    @if ($name && $errors->has($name))
        <div
            id="{{ $name }}-error"
            class="mt-1 text-sm text-red-600"
        >
            {{ $errors->first($name) }}
        </div>
    @endif

    @if ($descriptionTrailing)
        <div class="text-sm text-zinc-500 mt-2">
            {{ $descriptionTrailing }}
        </div>
    @endif
</div>
