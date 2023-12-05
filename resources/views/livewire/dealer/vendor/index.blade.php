<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($vendors as $key => $value)
        <div class="border rounded-md p-6">
            <h3 class="text-xl leading-6 font-black text-arm-blue-600">{{ $value[0]->store->name ?? 'Used in all Stores' }}</h3>
            <ul role="list" class="divide-y divide-gray-100">
                @foreach($value as $vendor)
                    <livewire:dealer.vendor.store-index-item :vendor="$vendor" :key="$vendor->id"/>
                @endforeach
            </ul>
        </div>
    @empty

    @endforelse
</div>
