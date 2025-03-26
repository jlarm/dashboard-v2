@props(['title' => '', 'subtitle' => ''])

<div {{ $attributes->merge(['class' => 'flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl']) }}>
    @if($title)
    <div class="p-5 pb-4">
        <div>
            <h2 class="inline-block font-semibold text-gray-800">
                {{ $title }}
            </h2>
            @if($subtitle)
            <p class="text-xs mb-5 text-gray-400 italic">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    @endif
    
    <div class="h-full p-5 pt-0 space-y-4">
        {{ $slot }}
    </div>
</div> 