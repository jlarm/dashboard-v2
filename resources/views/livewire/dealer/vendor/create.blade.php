<x-wire-elements-pro::tailwind.modal on-submit="create" :content-padding="true">
    <x-slot name="title">Add New Vendor</x-slot>

    <div class="space-y-5">
        @if(!$qi)
            <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            A Qualified Individual must be set before adding a vendor.
                        </p>
                    </div>
                </div>
            </div>
        @endif
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
            @if($stores)
                <div class="col-span-3">
                    <x-input-label for="store"
                                   :value="__('Select a Store if the vendor is only used at a specific store')"/>
                    <select
                        wire:model.defer="store"
                        name="store"
                        id="store"
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
            @if(!$qi) disabled @endif
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
