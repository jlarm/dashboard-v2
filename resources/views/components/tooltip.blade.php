@props([
     'content' => null,
     'position' => 'top',
 ])

<div class="relative inline-block group">
    <svg {{ $attributes->merge(['class' => '']) }} xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>

    @if($content)
        <div class="absolute z-50 px-3 py-2 text-xs font-medium text-white bg-zinc-800 rounded-md shadow-lg
                    opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200
                    {{ $position === 'top' ? 'bottom-full left-1/2 -translate-x-1/2 mb-2' : 'top-full left-1/2 -translate-x-1/2 mt-2' }}
                    max-w-sm whitespace-nowrap pointer-events-none">
            {{ $content }}
        </div>
    @endif
</div>
