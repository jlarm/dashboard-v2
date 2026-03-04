<div class="px-3 mb-1.5">
    <a
        href="{{ $item['href'] }}"
        @if(isset($item['target'])) target="{{ $item['target'] }}" rel="noreferrer noopener" @endif
        class="{{ $item['active'] ? 'bg-gray-100 text-gray-600' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }} border-transparent group flex items-center rounded-lg py-1.5 px-2.5 text-[13px]"
    >
        @include('livewire.dealer.navigation.icon', ['name' => $item['icon'], 'active' => $item['active']])
        {{ $item['label'] }}
    </a>
</div>
