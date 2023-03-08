<div>
    @foreach($stores as $store)
        <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1"
           id="menu-item-2">{{ $store->name }}</a>
    @endforeach
</div>
