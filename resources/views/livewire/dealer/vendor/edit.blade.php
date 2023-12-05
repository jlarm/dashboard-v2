<x-wire-elements-pro::tailwind.modal on-submit="update">
    <x-slot name="title">Edit {{ $vendor->name }}</x-slot>

    <div class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
            <div class="mt-1">
                <input wire:model.defer="name" type="text" name="name" id="name"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Contact Name</label>
            <div class="mt-1">
                <input wire:model.defer="contactName" type="text" name="contactName" id="contactName"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                @error('contactName')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Contact Email</label>
            <div class="mt-1">
                <input wire:model.defer="contactEmail" type="text" name="contactEmail" id="contactEmail"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                @error('contactEmail')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @if(tenant('locations'))
            <div>
                <div class="col-span-3">
                    <x-input-label for="store_id"
                                   :value="__('Select a Store if the vendor is only used at a specific store')"/>
                    <select
                        wire:model.defer="store_id"
                        name="store_id"
                        id="store_id"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-arm-blue-500 focus:outline-none focus:ring-arm-blue-500 sm:text-sm"
                    >
                        <option></option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
    </div>

    <x-slot name="buttons">
        <x-primary-button type="submit">Update</x-primary-button>
        <x-secondary-button type="button" wire:click="$emit('modal.close')">Cancel</x-secondary-button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
