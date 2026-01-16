<div onclick="Livewire.emit('slide-over.open', 'dealer.vendor.edit', @js(['vendor' => $vendor->id]))" class="p-4 flex flex-col bg-white border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
    <div class="space-y-1">
        <div class="flex justify-between items-center mb-2.5">
            <h4 class="font-medium text-sm text-gray-800">
                {{ ucwords(strtolower(Str::limit($vendor->name, 20)))  }}
            </h4>
        </div>

        @if(tenant('locations'))
        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
            <span class="text-xs text-gray-600">
              Store:
            </span>

            <span class="text-xs text-gray-600">
              {{ $vendor->store ? Str::limit($vendor->store->name, 20) : 'All Stores' }}
            </span>
        </div>
        <!-- End Item -->
        @endif

        <!-- Item -->
        <div class="flex justify-between items-center gap-x-2">
            <span class="text-xs text-gray-600">
              Status:
            </span>

            <span
                @class([
                    'inline-flex items-center gap-x-1.5 py-0.5 px-1.5 rounded-md text-xs font-medium',
                    'bg-teal-100 text-teal-800' => $this->isCompleted(),
                    'bg-red-100 text-red-800' => 'default',
                ])
            >
                {{ $this->isCompleted() ? 'Current' : 'Incomplete' }}
            </span>
        </div>
        <!-- End Item -->
    </div>
</div>
