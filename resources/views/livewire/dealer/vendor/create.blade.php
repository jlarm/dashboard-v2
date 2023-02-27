<x-wire-elements-pro::tailwind.modal on-submit="create" :content-padding="true">
    <x-slot name="title">Add New Vendor</x-slot>

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
            <label for="contact_name" class="block text-sm font-medium text-gray-700">Contact Name</label>
            <div class="mt-1">
                <input wire:model.defer="contact_name" type="text" name="contact_name" id="contact_name"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                @error('contact_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div>
            <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
            <div class="mt-1">
                <input wire:model.defer="contact_email" type="text" name="contact_email" id="contact_email"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-arm-blue-500 focus:ring-arm-blue-500 sm:text-sm">
                @error('contact_email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div>
            @if(tenant('locations'))
                <div class="col-span-3">
                    <x-input-label for="store_id" :value="__('Select a Store')"/>
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
            @endif
        </div>
    </div>

    <x-slot name="buttons">
        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-arm-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-arm-blue-700 focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Create
        </button>
        <button
            type="button"
            wire:click="$emit('modal.close')"
            class="inline-flex items-center justify-center rounded-md border border-arm-blue-600 px-4 py-2 text-sm font-medium text-arm-blue-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-arm-blue-500 focus:ring-offset-2 sm:w-auto"
        >
            Cancel
        </button>
    </x-slot>
</x-wire-elements-pro::tailwind.modal>
