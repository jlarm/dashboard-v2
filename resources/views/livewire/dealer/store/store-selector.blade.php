<div>
    @foreach($stores as $store)
        <a href="{{ route('dealer.stores.show', $store) }}"
           class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50"
           role="menuitem">{{ $store->name }}</a>
    @endforeach
</div>
