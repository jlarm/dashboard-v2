<div class="flex h-full flex-col {{ $hasStores ? '' : 'pointer-events-none opacity-50' }}">
    @if(! $hasStores)
        <div class="px-3 mb-2 text-xs text-gray-500">
            Create your first store to unlock navigation.
        </div>
    @endif
    <div>
        @foreach($primaryItems as $item)
            @if(($item['type'] ?? 'link') === 'group')
                @include('livewire.dealer.navigation.group', ['item' => $item])
            @else
                @include('livewire.dealer.navigation.item', ['item' => $item])
            @endif
        @endforeach
    </div>

    @if($secondaryItems !== [])
        <div class="mt-auto border-t border-gray-100 pt-3">
            @foreach($secondaryItems as $item)
                @include('livewire.dealer.navigation.item', ['item' => $item])
            @endforeach
        </div>
    @endif
</div>
